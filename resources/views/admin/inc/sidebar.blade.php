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
                    <span data-feather="tv"></span> Series
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/admin/series/"><span data-feather="monitor"></span> Browse Series</a>
                    <a class="dropdown-item" href="/admin/series/create"><span data-feather="folder-plus"></span> Create Series</a>
                    <a class="dropdown-item" href="/admin/series/createSeason"><span data-feather="plus-square"></span> Upload Season &amp; Episode</a>
                    <a class="dropdown-item" href="/admin/series/create"><span data-feather="disc"></span> Upload Episode</a>
                  </div>
                </div>
              </li>
              </li>
               <li class="nav-item">
                <a class="nav-link" href="/admin/ads">
                  <span data-feather="cast"></span>
                  Ads
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
                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span data-feather="shopping-cart"></span> Shop
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/admin/products/createCategory"><span data-feather="layers"></span> &nbsp;&nbsp;Create Category</a>
                    <a class="dropdown-item" href="/admin/products/createSubCategory"><span data-feather="list"></span> &nbsp;&nbsp;Sub Category</a>
                    <a class="dropdown-item" href="/admin/products/create"><span data-feather="shopping-bag"></span> &nbsp;&nbsp;Insert Product</a>
                    <a class="dropdown-item" href="/admin/products/"><span data-feather="edit"></span> &nbsp;&nbsp;Manage Products</a>
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