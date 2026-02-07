<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-link nav-link">Logout</button>
      </form>
    </li>
  </ul>
</nav>
