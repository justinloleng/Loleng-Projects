<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{


    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {

            $threads = DB::select(
                "
                SELECT threads.*, users.name AS author 
                FROM threads 
                JOIN users ON threads.user_id = users.id
                WHERE threads.title LIKE ? OR users.name LIKE ?
                ORDER BY threads.created_at DESC
            ",
                ["%$query%", "%$query%"]
            );
        } else {

            $threads = DB::select("
                SELECT threads.*, users.name AS author 
                FROM threads 
                JOIN users ON threads.user_id = users.id
                ORDER BY threads.created_at DESC
            ");
        }

        return view('index', compact('threads'));
    }

    public function create()
    {
        return view('create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);


        DB::insert('INSERT INTO threads (title, content, user_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
            $request->title,
            $request->content,
            auth()->id(),
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread created successfully!');
    }


    public function show($id)
    {
        $thread = DB::selectOne("
            SELECT threads.*, users.name AS author 
            FROM threads 
            JOIN users ON threads.user_id = users.id 
            WHERE threads.id = ?", [$id]);

        $replies = DB::select("
            SELECT replies.*, users.name AS author 
            FROM replies 
            JOIN users ON replies.user_id = users.id 
            WHERE replies.thread_id = ?
            ORDER BY replies.created_at ASC", [$id]);

        return view('show', compact('thread', 'replies'));
    }


    public function edit($id)
    {
        $thread = DB::selectOne('SELECT * FROM threads WHERE id = ?', [$id]);

        return view('edit', compact('thread'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        DB::update('UPDATE threads SET title = ?, content = ?, updated_at = NOW() WHERE id = ?', [
            $request->title,
            $request->content,
            $id,
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread updated successfully!');
    }


    public function destroy($id)
    {
        $thread = DB::select("SELECT * FROM threads WHERE id = ?", [$id]);

        if (!$thread) {
            return redirect()->back()->with('error', 'Thread not found.');
        }


        if (auth()->user()->id != $thread[0]->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        DB::delete("DELETE FROM threads WHERE id = ?", [$id]);

        return redirect()->route('threads.index')->with('success', 'Thread deleted successfully.');
    }



    public function storeReply(Request $request, $thread_id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        DB::insert('INSERT INTO replies (content, user_id, thread_id, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())', [
            $request->content,
            auth()->id(),
            $thread_id,
        ]);

        return redirect()->route('threads.show', $thread_id)->with('success', 'Reply added successfully!');
    }


    public function editReply($id)
    {
        $reply = DB::selectOne('SELECT * FROM replies WHERE id = ?', [$id]);

        return view('replies.edit', compact('reply'));
    }


    public function updateReply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        DB::update('UPDATE replies SET content = ?, updated_at = NOW() WHERE id = ?', [
            $request->content,
            $id,
        ]);

        return redirect()->back()->with('success', 'Reply updated successfully!');
    }

    public function destroyReply($id)
    {
        $reply = DB::select("SELECT * FROM replies WHERE id = ?", [$id]);

        if (!$reply) {
            return redirect()->back()->with('error', 'Reply not found.');
        }

        if (auth()->user()->id != $reply[0]->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        DB::delete("DELETE FROM replies WHERE id = ?", [$id]);

        return redirect()->back()->with('success', 'Reply deleted successfully.');
    }
}
