<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Nhiệm vụ';
        $tickets = Ticket::get();
        return view('backend.tickets.index',compact(
            'title','tickets'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->validate($request, [
        'subject' => 'required',
        'staff' => 'required',
        'client' => 'required',
        'priority' => 'required',
        'project' => 'required',
        'description' => 'required',
        'files' => 'nullable',
        'status' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    $files = null;
    if ($request->hasFile('files')) {
        $files = [];
        foreach ($request->file('files') as $file) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/tickets/' . $request->subject), $fileName);
            $files[] = $fileName;
        }
    }

    $uuid = IdGenerator::generate(['table' => 'tickets', 'field' => 'tk_id', 'length' => 9, 'prefix' => '#NV-']);
    Ticket::create([
        'subject' => $request->subject,
        'tk_id' => $request->ticket_id ?? $uuid,
        'employee_id' => $request->staff,
        'client_id' => $request->client,
        'priority' => $request->priority,
        'project_id' => $request->project,
        'files' => $files,
        'status' => $request->status,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    $notification = notify('Thêm nhiệm vụ thành công');
    return back()->with($notification);
}

    /**
     * Display the specified resource.
     *
     * @param  string $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($ticket)
    {
        $title = 'Xem chi tiết nhiệm vụ';        
        $ticket = Ticket::where('subject','=',$ticket)->firstOrFail();
        return view('backend.tickets.show',compact(
            'title','ticket'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required',
            'staff' => 'required',
            "client" => "required",
            "priority" => "required",
            "project" => "required",
            "description" => 'required',
            "files" => 'nullable',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $ticket = Ticket::findOrFail($request->id);
        $files = $ticket->files;
        if(!empty($request->files)){
            $files = array();
            $index = 0;
            foreach($request->files as $file){
                $fileName = time().$index.'.'.$file[$index]->getClientOriginalExtension();
                $file[$index]->move(public_path('storage/tickets/'.$request->subject), $fileName);
                array_push($files,$fileName);
                $index++;
            }
        }
        $ticket->update([
            'subject'=> $request->subject,
            'employee_id' => $request->staff,
            'client_id' => $request->client,
            'priority' => $request->priority,
            'project_id' => $request->project,
            'files' => $files,
            'status' => $request->status,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $notification = notify('Nhiệm vụ được cập nhật');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Ticket::findOrFail($request->id)->delete();
        $notification = notify('Xóa nhiệm vụ thành công');
        return back()->with($notification);
    }
}
