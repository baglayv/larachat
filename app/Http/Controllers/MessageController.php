<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    //
    public function showListChat($userHostId)
    {
        
         $validate = $request->validate([
            'message' => 'required|max:255',
           ]);
        $chat_id = $this->chatId($userHostId, Auth::id());
        
        
    
        $messages = $chat_id ? Message::where('chat_id', $chat_id)->get() : [];
        $user = User::findOrFail($userHostId);

        return view('chat', compact('messages', 'user'));
     
    }

    public function store(Request $request, $userHostId)
    {
    
        
        $chat_id = $this->chatId($userHostId, Auth::id());
      
        if(!$chat_id) {
            $chat = Chat::create();
            // записываю связь авторизованного пользователя и чата в таблицу, 
            // а также связываю пользователя получателя и таблицу чата
            // таблица связи chat_user
            $users = User::find([$userHostId, Auth::id()]);
            $chat->users()->attach($users);
            $chat_id = $chat->id;
        }
        


       
        $message = new Message();
        $message->chat_id = $chat_id;
        $message->user_id = Auth::id();
        $message->message = $request->input('message');
        $message->save();
       

        
        return redirect()->route('chat', ['userHostId' => $userHostId]);



    }

    private function chatId($user1, $user2)
    {
        // выбираю коллекции по юзерам участвующим в беседе
        $collection1 = ChatUser::select('chat_id')->where('user_id', $user1)->pluck('chat_id');
        $collection2 = ChatUser::select('chat_id')->where('user_id', $user2)->pluck('chat_id');
        // объединяю коллекции и выбираю дубликат, это и  будет значение chat_id
        $collection = collect();
        $collection = $collection->merge($collection1);
        $collection = $collection->merge($collection2);
        
        $duplication = $collection->duplicates()->toArray();
        return $duplication ? array_values($duplication)[0] : 0;
       
        
    }
}
