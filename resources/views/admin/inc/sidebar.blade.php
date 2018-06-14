    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column"><br>
              <h7  class="nav-link">
                  Howdy, {{Auth::user()->name}}!
              </h7  >
              <li class="nav-item">
                <a class="nav-link active" href="/admin/home">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/admin/movies">
                  <span data-feather="film"></span>
                  Movies
                </a>
              </li>
              <li class="nav-item">
                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span data-feather="headphones"></span> Music
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/admin/musics"><span data-feather="music"></span> &nbsp;&nbsp;Browse Artists &amp; Albums</a>
                    <a class="dropdown-item" href="/admin/musics/createArtist"><span data-feather="user-plus"></span> &nbsp;&nbsp;Create Artists &amp; Albums</a>
                    <a class="dropdown-item" href="/admin/musics/create"><span data-feather="headphones"></span> &nbsp;&nbsp;Upload Song</a>
                  </div>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  News
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Users</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Passengers
                </a>
              </li>
            </ul>
          </div>
        </nav>