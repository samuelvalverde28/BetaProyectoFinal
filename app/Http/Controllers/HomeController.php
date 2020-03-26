<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Image;
use App\GamesPlatform;
use App\Platform;
use App\Users_game;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
        return view('home', compact(['Usersgame']));
    }

    public function all(Request $request)
    {
        $nombrejuegos = $request->get('buscarjuegos');
        
        $Game = Game::orderBy('name','ASC')->where('name','like',"%$nombrejuegos%")->paginate(10);
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        // return(dd($Game));
        return view('all', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }

    public function guardar($id)
    {
        // return dd($id);
        // return dd($request);
        $Usersgame = new Users_game;
        $Usersgame->idgames = $id;
        $Usersgame->idusers = Auth::user()->id;
        $Usersgame->estado = 'jugando';
        $Usersgame->save();

        return redirect('all')->with('datos', 'Juego añadido a su catálogo correctamente!');
        
    }


    public function borrar($id)
    {
        // return dd($id);

        Users_game::where('idgames', $id)->where('idusers', Auth::user()->id)->delete();
        
        return redirect('all')->with('datos',  'Juego borrado de su catálogo correctamente!');
        
    }

   

    public function catalogo(){
        $Game = Game::all();
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        return view('cliente.catalogo', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }

    public function jugando(){
        $Game = Game::all();
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        return view('cliente.jugando', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }

    public function completado(){
        $Game = Game::all();
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        return view('cliente.completado', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }


    public function espera(){
        $Game = Game::all();
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        return view('cliente.espera', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }


    public function dejado(){
        $Game = Game::all();
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        $Usersgame = Users_game::all();
        return view('cliente.dejado', compact(['Game', 'Image', 'GamesPlatform', 'Platform', 'Usersgame']));
    }

    public function actualizarEstado(Request $request, $id)
    {
        
        Users_game::where('idgames', $id)->where('idusers', Auth::user()->id)->update(["estado" => $request->estad]);
        
        return redirect('catalogo')->with('datos',  'Juego actualizado de su catálogo correctamente!');

    }



    


    public function configUsuarios(){
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }

            

            $User = User::all();
            return view('admin.configUsuarios', compact('User'));
        

        
    }

    public function borrarUsuarios($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // return dd($id);

        User::where('id', $id)->delete();
        
        return redirect('configUsuarios')->with('datos',  'Usuario borrado de su base de datos correctamente!');
        
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // dd($request->all());

        if ( $request->name == null && $request->email == null) {
            User::where('id', $id)->update([ "role" => $request->rol ]);
            return redirect('configUsuarios')->with('datos',  'Usuario actualizado de la base de datos correctamente!');
        }

        if ($request->email == null) {
            User::where('id', $id)->update(["name" => $request->name, "role" => $request->rol ]);
            return redirect('configUsuarios')->with('datos',  'Usuario actualizado de la base de datos correctamente!');
        }

        if ( $request->name == null) {
            User::where('id', $id)->update([  "email" => $request->email, "role" => $request->rol ]);
            return redirect('configUsuarios')->with('datos',  'Usuario actualizado de la base de datos correctamente!');
        }

        

        $usuarios = User::all();
        foreach ($usuarios as $us) {
            if ($us->email == $request->email) {
                return redirect('configUsuarios')->with('cancelar', 'Error el correo ya existe');
            }
        }

        User::where('id', $id)->update(["name" => $request->name, "email" => $request->email, "role" => $request->rol ]);
        
        return redirect('configUsuarios')->with('datos',  'Usuario actualizado de la base de datos correctamente!');

    }

    public function actualizar($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
    
        $Usuario = User::all()->where('id', $id); 
        return view('admin.actualizar', compact([ 'Usuario']));

    }



    public function nuevoUsuario(Request $request)
    {   

        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }

        if ($request->password != $request->password_confirmation) {
            return redirect('configUsuarios')->with('cancelar', 'Error!! vuelve a intentarlo.');
        }

        $usuari = User::all();
        foreach ($usuari as $us) {
            if ($us->email == $request->email) {
                return redirect('configUsuarios')->with('cancelar', 'Error!! vuelve a intentarlo.');
            }
        }
        
        $usuario = new User;
        $usuario->name = $request->name; 
        $usuario->email = $request->email; 
        $usuario->password = Hash::make($request->password); 
        $usuario->role = $request->rol; 
        $usuario->save();

        return redirect('configUsuarios')->with('datos', 'Usuario añadido correctamente!');

    }




    public function configJuegos(Request $request){
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        
        
        $nombrejuegos = $request->get('buscarjuegos');
        $Game = Game::orderBy('name','ASC')->where('name', 'like', "%$nombrejuegos%")->paginate(12);
        $Image = Image::all();
        $GamesPlatform = GamesPlatform::all();
        $Platform = Platform::all();
        //dd($Platform); 
            return view('admin.configJuegos', compact(['Game', 'Image', 'GamesPlatform', 'Platform']));
        
    }

    public function borrarJuegos($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // return dd($id);

        Game::where('id', $id)->delete();
        
        return redirect('configJuegos')->with('datos',  'Juego borrado de su base de datos correctamente!');
        
    }

    public function nuevoJuego(Request $request)
    {   
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }

        $Platform = Platform::all();

        if ($request->id == null) {
            return redirect('configJuegos')->with('cancelar', 'No has introducido ID!');
        }

        $juegos = Game::all();
        foreach ($juegos as $game) {
            if($request->id == $game->id){
                return redirect('configJuegos')->with('cancelar', 'El ID ya existe!');
            }
        }

        
        

        $games = new Game;
        $games->id = $request->id;
        $games->name = $request->name;
        $games->released = $request->released;
        $games->background_image = $request->background_image;
        $games->rating = $request->rating;
        $games->rating_top = $request->rating_top;
        $games->clip = $request->clip;
        $games->save();


        $i=1;
        foreach ($Platform as $plat) {
            
            if($plat->id == $request->$i){
                $gp = new GamesPlatform;
                $gp->idgames = $request->id;
                $gp->idplatforms = $request->$i;     
                $gp->save();
            }
            $i++;

        }

        return redirect('configJuegos')->with('datos', 'Juego añadido correctamente!');

    }    


    public function actualizarJue($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
    
        $Game = Game::all()->where('id', $id); 
        $Platform = Platform::all();
        $GamePlatform = GamesPlatform::all();
        return view('adminJuegos.actualizarJue', compact([ 'Game', 'Platform', 'GamePlatform']));

    }


    public function actualizarJuego(Request $request, $id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // return dd($request->all());
        $Platform = Platform::all();
        $games = Game::all();

        GamesPlatform::where('idgames', $id)->delete();

        $i=1;
        foreach ($Platform as $plat) {
            
            if($plat->id == $request->$i){
                $gp = new GamesPlatform;
                $gp->idgames = $id;
                $gp->idplatforms = $request->$i;     
                $gp->save();
            }
            $i++;

        }


        if($request->name != null){
            Game::where('id', $id)->update([ 
                "name" => $request->name
            ]);
        }

        if($request->released != null){
            Game::where('id', $id)->update([ 
                "released" => $request->released
            ]);
        }

        if($request->background_image != null){
            Game::where('id', $id)->update([ 
                "background_image" => $request->background_image   
            ]);
        }

        if($request->clip != null){
            Game::where('id', $id)->update([ 
                "clip" => $request->clip
            ]);
        }

        if($request->rating != null){
            Game::where('id', $id)->update([ 
                "rating" => $request->rating
            ]);
        }

        if($request->rating_top != null){
            Game::where('id', $id)->update([ 
                "rating_top" => $request->rating_top
            ]);
        }

        
        
        return redirect('configJuegos')->with('datos',  'juego actualizado de la base de datos correctamente!');

    }



    public function configImagenes($id){
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        
        $Image = Image::where('idgames', $id)->get();

        return view('adminImagenes.configImagenes', compact(['Image']));
        
    }

    public function borrarImagenes($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // return dd($id);

        Image::where('id', $id)->delete();
        
        return redirect('configJuegos')->with('datos',  'Imagen borrado de su base de datos correctamente!');
        
    }

    public function nuevoImagen($id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        
        $ID = $id;
        
        
        return view('adminImagenes.nuevaImagen', compact(['ID']));
        
    }

    public function agregarImagen(Request $request, $id)
    {
        $rol = Auth::user()->role;
        if( $rol != 'admin'){
            $Usersgame = Users_game::all()->where('idusers', Auth::user()->id);
            return view('home', compact(['Usersgame']));
        }
        // return dd($id);
        // return dd($request->all());
                   
        $image = new Image;
        $image->idgames = $id;
        $image->img = $request->img;     
        $image->save();
              
        
        return redirect('configJuegos')->with('datos',  'juego Añadirdo de la base de datos correctamente!');

    }

    




    
}