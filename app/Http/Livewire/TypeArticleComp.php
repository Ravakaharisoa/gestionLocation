<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TypeArticle;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class TypeArticleComp extends Component
{
	use WithPagination;
	protected $paginationTheme = "bootstrap";

	public $search = "";
	public $isAddTypeArticle = false;
	public $newTypeArticleName ="";
	public $newValue = "";


    public function render()
    {
    	$searchCriteria = "%".$this->search."%";
    	
    	$data = [
    		"typearticles"=>TypeArticle::where("nom","like",$searchCriteria)->latest()->paginate(5)
    	];
        return view('livewire.typearticles.index',$data)
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleShowAddTypeArticleForm()
    {
    	if ($this->isAddTypeArticle) {
    		$this->isAddTypeArticle = false;
    		$this->newTypeArticleName ="";
    		$this->resetErrorBag(["newTypeArticleName"]);
    	}
    	else{
    		$this->isAddTypeArticle = true;
    	}
    }

    public function addNewTypeArticle()
    {
    	$validated =$this->validate([
    		"newTypeArticleName" =>"required|max:50|unique:type_articles,nom"
    	]);

    	TypeArticle::create(["nom"=>$validated["newTypeArticleName"]]);

    	$this->toggleShowAddTypeArticleForm();
    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Type article ajoutée avec succès!"]);
    }
   /* public function editTypeArticle($id)
    {
    	$typeArticle = TypeArticle::find($id);
    	$this->dispatchBrowserEvent("showEditForm",["typearticle"=>$typeArticle]);
    	
    } ou ce code en bas*/

    public function editTypeArticle(TypeArticle $typeArticle)
    {
    	$this->dispatchBrowserEvent("showEditForm",["typearticle"=>$typeArticle]);
    }

    /*public function updateTypeArticle($id,$newValueJs)
    {
    	$this->newValue = $newValueJs;
    	$validated =$this->validate([
    		"newValue" =>["required","max:50",Rule::unique("type_articles","nom")->ignore($id)]
    	]);

    	TypeArticle::find($id)->update(["nom"=>$validated["newValue"]]);
    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Type article mis à jour avec succès!"]);
    }*/

    public function updateTypeArticle(TypeArticle $typeArticle,$newValueJs)
    {
    	$this->newValue = $newValueJs;
    	$validated =$this->validate([
    		"newValue" =>["required","max:50",Rule::unique("type_articles","nom")->ignore($typeArticle->id)]
    	]);

    	$typeArticle->update(["nom"=>$validated["newValue"]]);
    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Type article mis à jour avec succès!"]);
    }

    public function confirmDelete($name,$id)
    {
    	$this->dispatchBrowserEvent("showConfirmMessage",["message"=>[
    		"text"=>'Vous êtes sur le point de supprimer '.$name.' de la liste de type d\'article. Voulez-vous continuer?',
    		"title"=>'Etes-vous sûr de continuer ?',
    		"type"=>'warning',
    		"data"=>["type_article_id"=>$id]
    		]
    	]);
    }

    public function deleteTypeArticle(TypeArticle $typeArticle)
    {
    	$typeArticle->delete();

    	$this->dispatchBrowserEvent("showSuccessMessage",["message"=>"Type article supprimée avec succès!"]);
    }

    public function showProp(TypeArticle $typeArticle)
    {
    	$this->dispatchBrowserEvent("showModal",[]);
    }
}
