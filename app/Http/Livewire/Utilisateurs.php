<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Utilisateurs extends Component
{
	use WithPagination;
	protected $paginationTheme = "bootstrap";

	public $currentPage = PAGELIST;
	public $newUser = [];
	public $editUser = [];
	public $rolePermissions = [];

	/*protected $messages = [
		'newUser.nom.required
		' => "Le nom d'utilisateurs est requis.",

	];

	protected $validationAttributes = [
		'newUser.telephone1' => 'numero de telephone 1',
	];*/

    public function render()
    {
        return view('livewire.utilisateurs.index',[
        	"users"=> User::latest()->paginate(5)
        ])->extends("layouts.master")
        ->section("contenu");
    }

    public function rules()
    {
    	if ($this->currentPage == PAGEEDITFORM) {
    		return [
    			'editUser.nom' => 'required',
				'editUser.prenom' => 'required',
				'editUser.sexe' => 'required',
				'editUser.email' => ['required','email',Rule::unique("users","email")->ignore($this->editUser['id'])],
				'editUser.telephone1' => ['required','numeric',Rule::unique("users","telephone1")->ignore($this->editUser['id'])],
				'editUser.pieceIdentite' => 'required',
				'editUser.numeroPieceIdentite' => ['required',Rule::unique("users","numeroPieceIdentite")->ignore($this->editUser['id'])],
    		];
    	}

    	return [
			'newUser.nom' => 'required',
			'newUser.prenom' => 'required',
			'newUser.sexe' => 'required',
			'newUser.email' => 'required|email|unique:users,email',
			'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
			'newUser.telephone2' => 'numeric',
			'newUser.pieceIdentite' => 'required',
			'newUser.numeroPieceIdentite' => 'required|unique:users,numeroPieceIdentite'
		];
    }

    public function goToAddUser()
    {
    	$this->currentPage = PAGECREATEFORM;
    }

    public function goToEditUser($id)
    {
    	$this->editUser = User::find($id)->toArray();
    	$this->currentPage = PAGEEDITFORM;

    	$this->populateRolePermissions();


    }

    public function populateRolePermissions()
    {
    	$this->rolePermissions["roles"] = [];
    	$this->rolePermissions["permissions"] = [];
        $mapForOB = function($value){
            return $value['id'];
        };
    	$roleIds = array_map($mapForOB, User::find($this->editUser['id'])->roles->toArray());
        $permissionIds = array_map($mapForOB, User::find($this->editUser['id'])->permissions->toArray());
    	
        foreach (Role::all() as $role) {
            if (in_array($role->id, $roleIds)) {
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id,"role_nom"=>$role->nom,"active"=>true]);
            }
            else{
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id,"role_nom"=>$role->nom,"active"=>false]);
            }
        }

        foreach (Permission::all() as $permission) {
            if (in_array($permission->id, $permissionIds)) {
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id,"permission_nom"=>$permission->nom,"active"=>true]);
            }
            else{
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id,"permission_nom"=>$permission->nom,"active"=>false]);
            }
        }

    }

    public function updateRoleAndPermission()
    {
        DB::table("user_role")->where("user_id",$this->editUser["id"])->delete();
        DB::table("user_permission")->where("user_id",$this->editUser["id"])->delete();

        foreach ($this->rolePermissions["roles"] as $role) {
            if ($role["active"]) {
                User::find($this->editUser["id"])->roles()->attach($role["role_id"]);
            }
            
        }

        foreach ($this->rolePermissions["permissions"] as $permission) {
            if ($permission["active"]) {
                User::find($this->editUser["id"])->permissions()->attach($permission["permission_id"]);
            }
        }

        $this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Role et permission mis à jour avec succès!"]);
    }

    public function goToListUser()
    {
    	$this->currentPage = PAGELIST;
    	$this->editUser = [];
    }

    public function addUser()
    {
    	
    	//Vérifier que les informations envoyées par le formulaire sont correctes
    	$validationAttributes = $this->validate();
    	$validationAttributes['newUser']["password"] = "password";
    	$validationAttributes['newUser']["photo"] = "https://via.placeholder.com/640x480.png/00bb00?text=fugit";
    	// Ajouter un nouvel utilisateur
    	User::create($validationAttributes['newUser']);
		
		$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Utilisateur créé avec succès!"]);

		$this->newUser = [];
		$this->currentPage = PAGELIST;
    }

    public function updateUser()
    {
    	$validationAttributes = $this->validate();

    	User::find($this->editUser["id"])->update($validationAttributes['editUser']);

    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Utilisateur modifié avec succès!"]);
    	$this->currentPage = PAGELIST;
    }

    public function confirmPwdReset()
    {
    	$this->dispatchBrowserEvent("showConfirmMessage",["message"=>[
    		"text"=>'Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateur. Voulez-vous continuer?',
    		"title"=>'Etes-vous sûr de continuer ?',
    		"type"=>'warning',
    	]]);
    }

    public function resetPassword()
    {
    	User::find($this->editUser["id"])->update(["password"=>Hash::make(DEFAULTPASSWORD)]);
    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Mot de passe utilisateur réinitialisé avec succès!"]);
    }

    public function confirmDelete($name,$id)
    {
    	$this->dispatchBrowserEvent("showConfirmMessage",["message"=>[
    		"text"=>'Vous êtes sur le point de supprimer '.$name.' de la liste des utilisateurs. Voulez-vous continuer?',
    		"title"=>'Etes-vous sûr de continuer ?',
    		"type"=>'warning',
    		"data"=>["user_id"=>$id]
    		]
    	]);
    }

    public function deleteUser($id)
    {
    	User::destroy($id);

    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Utilisateur supprimée avec succès!"]);
    }
}
