<div class="row col-md-12 my-3">
  <div class="col-md-7">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus fa-2x"></i> Edition utilisateur</h3>
      </div>
      <form role="form" wire:submit.prevent="updateUser()">
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Nom</label>
                  <input type="text" wire:model="editUser.nom" class="form-control @error('editUser.nom') is-invalid @enderror">

                  @error('editUser.nom') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Prénom</label>
                  <input type="text" wire:model="editUser.prenom" class="form-control @error('editUser.prenom') is-invalid @enderror">

                  @error('editUser.prenom') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Sexe</label>
              <select class="form-control @error('editUser.sexe') is-invalid @enderror" wire:model="editUser.sexe">
                <option value="">===============</option>
                <option value="F">Femme</option>
                <option value="H">Homme</option>
              </select>

              @error('editUser.sexe') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
              <label>Adresse e-mail</label>
              <input type="text" wire:model="editUser.email" class="form-control @error('editUser.email') is-invalid @enderror">

                  @error('editUser.email') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="d-flex">
              <div class="form-group flex-grow-1 mr-2">
                <label>Télephone 1</label>
                <input type="text" wire:model="editUser.telephone1" class="form-control @error('editUser.telephone1') is-invalid @enderror" data-inputmask="'mask': ['999-99-999-99 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>

                  @error('editUser.telephone1') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
              <div class="form-group flex-grow-1">
                <label>Télephone 2</label>
                <input type="text" wire:model="editUser.telephone2" class="form-control @error('editUser.telephone2') is-invalid @enderror" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>

                  @error('editUser.telephone2') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
              </div>
            </div>
            <div class="form-group">
              <label>Pièce d'identité</label>
              <select class="form-control @error('editUser.pieceIdentite') is-invalid @enderror" wire:model="editUser.pieceIdentite">
                <option value="">==========</option>
                <option value="CNI">CNI</option>
                <option value="PASSPORT">PASSPORT</option>
                <option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>
              </select>
              @error('editUser.pieceIdentite') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
            <div class="form-group">
              <label>Numéro du pièce d'identité</label>
              <input type="text" wire:model="editUser.numeroPieceIdentite" class="form-control @error('editUser.numeroPieceIdentite') is-invalid @enderror">

              @error('editUser.numeroPieceIdentite') 
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex">
              <button type="submit" class="btn btn-primary">Appliquer les modifications</button>
              <a wire:click.prevent="goToListUser()" href="#" class="btn btn-danger ml-1">Retour à la liste des utilisateurs</a>
            </div>
        </div>
      </form>
    </div>
  </div>

  <div class="col-md-5">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-key fa-2x"></i> Réinitialisation de mot de passe</h3>
        </div>
        <div class="card-body">
          <ul>
            <li>
              <a href="" class="btn btn-link" wire:click.prevent="confirmPwdReset()">Réinitialiser le mot de passe</a>
              <span>(par défaut:"password")</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="mt-5 col-md-12">
      <div class="card card-primary">
        <div class="card-header d-flex align-items-center">
          <h3 class="card-title flex-grow-1"><i class="fas fa-fingerprint fa-2x"></i> Roles & Permissions</h3>
          <button class="btn bg-gradient-success" wire:click="updateRoleAndPermission()"><i class="fas fa-check"></i> Appliquer les modifications</button>
        </div>
        <div class="card-body">
          <div id="accordion">
            @foreach($rolePermissions["roles"] as $role)
            <div class="card">
              <div class="card-header d-flex justify-content-between">
                <h4 class="card-title flex-grow-1">
                  <a href="#" data-parent="#accordion" aria-expanded="true">{{$role["role_nom"]}}</a>
                </h4>
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" wire:model.lazy="rolePermissions.roles.{{$loop->index}}.active"
                    @if($role['active']) checked @endif 
                    id='customSwitch{{$role["role_id"]}}'>
                    <label class="custom-control-label" for='customSwitch{{$role["role_id"]}}'>{{$role["active"]? "Activé" : "Désactivé"}}</label>
                  </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <div class="p-3">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Permissions</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($rolePermissions["permissions"] as $permission)
              <tr>
                <td>{{$permission['permission_nom']}}</td>
                <td>
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="custom-control-input" wire:model.lazy="rolePermissions.permissions.{{$loop->index}}.active"
                    @if($permission['active']) checked @endif id="customSwitchPermission{{$permission['permission_id']}}">
                    <label class="custom-control-label" for="customSwitchPermission{{$permission['permission_id']}}">{{$permission["active"]? "Activé" : "Désactivé"}}</label>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
