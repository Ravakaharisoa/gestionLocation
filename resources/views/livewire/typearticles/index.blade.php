<div class="col-12 mt-2">

  <div class="modal fade" id="modalProp" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header bg-gradient-primary d-flex align-items-center">
      <h3 class="card-title flex-grow-1"><i class="fas fa-list fa-2x"></i>  Liste des types d'articles</h3>
      <div class="card-tools d-flex d-block align-items-center">
        <a href="#" class="btn btn-link text-white mr-4" wire:click="toggleShowAddTypeArticleForm"><i class="fas fa-user-plus"></i> Nouveau type d'article</a>
        <div class="input-group input-group-md" style="width: 250px;">
          <input type="text" name="table_search" wire:model.debounce="search" class="form-control float-right" placeholder="Search">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive p-0 table-striped" style="height: 400px;">
      <table class="table table-head-fixed text-nowrap">
        <thead>
          <tr>
            <th style="width:50%;">Type d'article</th>
            <th class="text-center" style="width:20%;">Ajouté</th>
            <th class="text-center" style="width:30%;">Action</th>
          </tr>
        </thead>
        <tbody>
        	@if($isAddTypeArticle)
        		<tr>
        			<td colspan="2">
        				<input type="text" wire:keydown.enter="addNewTypeArticle"
                 class="form-control @error('newTypeArticleName') is-invalid @endif" wire:model="newTypeArticleName"/>
                @error('newTypeArticleName')
                  <span class="text-danger">{{$message}}</span>
                @enderror
        			</td>
        			<td class="text-center">
        				<button class="btn btn-sm btn-link" wire:click="addNewTypeArticle"><i class="fas fa-check"></i> Valider</button>
              			<button class="btn btn-sm btn-link" wire:click="toggleShowAddTypeArticleForm"><i class="fas fa-trash-alt"></i> Annuler</button>
        			</td>
        		</tr>
        	@endif
          
        	@foreach($typearticles as $typearticle)
          <tr>
            <td>{{$typearticle->nom}}</td>
            <td>{{ optional($typearticle->created_at)->diffForHumans()}}</td>
            <td class="text-center">
              <button class="btn btn-sm btn-link" wire:click="editTypeArticle({{$typearticle->id}})"><i class="fas fa-edit"></i></button>
              <button class="btn btn-sm btn-link" wire:click="showProp({{$typearticle->id}})"><i class="fas fa-list"></i> Propriétés</button>
              <button class="btn btn-sm btn-link" wire:click="confirmDelete('{{$typearticle->nom}}',{{$typearticle->id}})"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <div class="float-right">
      	{{$typearticles->links()}}
      </div>
    </div>
  </div>
</div>


<script>
    window.addEventListener("showSuccessMessage",event=>{
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: event.detail.message,
        showConfirmButton: false,
        timer: 5000,
        toast:true
      })
    });
</script>

<script>
  window.addEventListener('showEditForm',function(e){
    Swal.fire({
      title:"Edition d'un type d'article",
      input:'text',
      inputValue:e.detail.typearticle.nom,
      showCancelButton:true,
      confirmButtonColor:'#3085d6',
      cancelButtonColor:'#d33',
      confirmButtonText:'<i class="fas fa-check"></i> Modifier',
      cancelButtonText:'<i class="fas fa-times"></i> Annuler',
      inputValidator:(value)=>{
        if (!value) {
          return 'Champ obligatoire!';
        }
        @this.updateTypeArticle(e.detail.typearticle.id,value)
      }
    });
  });
</script>

<script>
    window.addEventListener("showConfirmMessage",event=>{
      Swal.fire({
        title:event.detail.message.title,
        text:event.detail.message.text,
        icon:event.detail.message.type,
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#d33',
        confirmButtonText:'Continuer',
        cancelButtonText:'Annuler'
      }).then((result)=>{
        if (result.isConfirmed) {
          if (event.detail.message.data) {
            @this.deleteTypeArticle(event.detail.message.data.type_article_id)
          }
          
        }
      });
    });
</script>

<script>
  window.addEventListener("showModal",event =>{
    $("#modalProp").modal("show")
  })
</script>

