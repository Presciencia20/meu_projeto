<?php

namespace App\Controllers;

use App\Models\ConversationModel;
use App\Models\MessageModel;
use App\Models\PropertyModel;
use CodeIgniter\Controller;

class Chat extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $model = new ConversationModel();
        $data['conversations'] = $model->getConversationsForUser(session()->get('user_id'));
        
        return view('chat/index', $data);
    }

    public function view($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $convModel = new ConversationModel();
        $msgModel = new MessageModel();
        
        $conversation = $convModel->find($id);
        if (!$conversation) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // Security check: user must be either tenant or owner (Admins can see everything)
        $userId = session()->get('user_id');
        $isAdmin = (session()->get('user_type') === 'Admin' || session()->get('user_type') === 'Super Admin');
        
        if (!$isAdmin && $conversation['tenant_id'] != $userId && $conversation['owner_id'] != $userId) {
            return redirect()->to('/dashboard')->with('error', 'Acesso negado.');
        }

        $data['conversation'] = $conversation;
        
        // Mark as read
        $msgModel->markAsReadInConversation($id, $userId);
        
        $data['messages'] = $msgModel->getMessagesForConversation($id);
        $data['userId'] = $userId;
        
        // Get other user info for header
        $otherUserId = ($conversation['tenant_id'] == $userId) ? $conversation['owner_id'] : $conversation['tenant_id'];
        $data['otherUser'] = (new \App\Models\UserModel())->find($otherUserId);
        $data['property'] = (new PropertyModel())->find($conversation['property_id']);

        return view('chat/view', $data);
    }

    public function send($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $msgModel = new MessageModel();
        $convModel = new ConversationModel();
        
        $text = $this->request->getPost('text');
        if (empty($text)) return redirect()->back();

        $userId = session()->get('user_id');

        $msgModel->insert([
            'conversation_id' => $id,
            'sender_id'       => $userId,
            'text'            => $text
        ]);

        // Update last message in conversation
        $convModel->update($id, [
            'last_message' => $text,
            'last_message_time' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to("/chat/view/$id");
    }

    public function start($propertyId)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $propModel = new PropertyModel();
        $property = $propModel->find($propertyId);
        
        $tenantId = session()->get('user_id');
        $ownerId = $property['owner_id'];

        if ($tenantId == $ownerId) return redirect()->back();

        $convModel = new ConversationModel();
        
        // Check if conversation already exists
        $existing = $convModel->where('property_id', $propertyId)
                             ->where('tenant_id', $tenantId)
                             ->first();

        if ($existing) {
            return redirect()->to("/chat/view/" . $existing['id']);
        }

        $convId = $convModel->insert([
            'property_id' => $propertyId,
            'tenant_id'   => $tenantId,
            'owner_id'    => $ownerId
        ]);

        return redirect()->to("/chat/view/$convId");
    }
}
