<aside class="control-sidebar control-sidebar-dark">
    <div class="bg-dark">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"src="{{asset('photos_users/user1.jpg')}}"
            alt="User picture">
        </div>
        <h3 class="profile-username text-center ellipsis">{{ userFullName() }}</h3>
        <p class="text-muted text-center">{{getRoleName()}}</p>
        <ul class="list-group bg-dark mb-3">
          <li class="list-group-item">
            <a href="#" class="d-flex align-items-center">
              <i class="fa fa-lock pr-2"></i>
              <b>Mot de passe</b>
            </a>
          </li>
          <li class="list-group-item">
            <a href="#" class="d-flex align-items-center">
              <i class="fa fa-user pr-2"></i>
              <b>Mon profile</b>
            </a>
          </li>
        </ul>
                                    
        <a href="{{ route('logout') }}" class="btn btn-primary btn-block" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Déconnexion</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </div>
  </aside>