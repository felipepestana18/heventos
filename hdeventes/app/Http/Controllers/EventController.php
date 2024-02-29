<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Event;
Use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request("search");
        if($search) {
                $events = Event::Where([
                    ['title', 'like', '%' . $search . '%']
                ])->get();
        } else {
            // PARA BUISCAR TODOS
            $events = Event::all();
        }
        return View('welcome', ["events"=>$events, "search"=>$search]);
    }

    public function create(){
        return View('events.create');
    }

    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->date = $request->date;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;

            // adicionado o usuário logado

            $user = auth()->user();
            $event->user_id = $user->id;
        }
        $event->save();
        return redirect("/")->with("msg","Evento Criado com Succeso!");
    }

    public function show ($id){

        $event = Event::findOrFail($id);
        $eventOwner = User::Where('id', $event->user_id)->first()->toArray();
        return view("events.show", ["event" => $event, "eventOwner" => $eventOwner]);
    }

    public function dashboard() {
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', 
            ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]
        );
    }

    public function destroy($id){

         Event::findOrFail($id)->delete();
         return redirect("dashboard")->with('msg', "Evento excluido com sucesso");
    }

    public function edit($id){
        $event = Event::findOrFail($id);
        return view("events.edit", ['event' => $event]);
    }

    public function update(Request $request) {

        $data = $request->all();

               // Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;

        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');

    }
    public function joinEvent($id){

        $user = auth()->user();

        print($user);

        // ligação n para n
        $user->eventsAsParticipant()->attach($id);


        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with("msg", "Sua Confirmação no evento está confirmada" . $event->title);

    }
    public function leaveEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

         return redirect('/dashboard')->with("msg", "Você saiu com sucesso do evento" . $event->title);
    }
}
