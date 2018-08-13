    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <h7 class="nav-link greeting">, {{Auth::user()->name}}!</h7>
              <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'home' ? ' active' : '' ?>" href="/admin/home?action=home">
                  <span data-feather="home"></span>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="nav-link dropdown-toggle"><span data-feather="film"></span>Movies</a>
                  <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'movies' ? ' active' : '' ?>" href="/admin/movies?action=movies"><span data-feather="film"></span> Browse Movies</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'movieCategory' ? ' active' : '' ?>" href="/admin/movies/createCategory?action=movieCategory"><span data-feather="layers"></span> Create Category</a>
                    </li>
                   </ul>
              </li>
              <li class="nav-item">
                <a href="#pageSubmenu0" data-toggle="collapse" aria-expanded="false" class="nav-link dropdown-toggle"><span data-feather="tv"></span>Series</a>
                  <ul class="collapse list-unstyled" id="pageSubmenu0">
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'browseseries' ? ' active' : '' ?>" href="/admin/series?action=browseseries"><span data-feather="monitor"></span> Browse Series</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'seriescreate' ? ' active' : '' ?>" href="/admin/series/create?action=seriescreate"><span data-feather="folder-plus"></span> Create Series</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'seasoncreate' ? ' active' : '' ?>" href="/admin/series/createSeason?action=seasoncreate"><span data-feather="plus-square"></span> Upload Season &amp; Episode</a>
                    </li>
                   </ul>
              </li>
               <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'ads' ? ' active' : '' ?>" href="/admin/ads?action=ads">
                  <span data-feather="cast"></span>
                  Ads
                </a>
              </li>
             <li class="nav-item">
                <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="nav-link dropdown-toggle"><span data-feather="headphones"></span> Music</a>
                  <ul class="collapse list-unstyled" id="pageSubmenu1">
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'browsemusic' ? ' active' : '' ?>" href="/admin/musics?action=browsemusic"><span data-feather="music"></span> &nbsp;&nbsp;Browse Artists &amp; Albums</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'createartist' ? ' active' : '' ?>" href="/admin/musics/createArtist?action=createartist"><span data-feather="user-plus"></span> &nbsp;&nbsp;Create Artists &amp; Albums</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'uploadsong' ? ' active' : '' ?>" href="/admin/musics/create?action=uploadsong"><span data-feather="headphones"></span> &nbsp;&nbsp;Upload Song</a>
                    </li>
                   </ul>
              </li>
              <li class="nav-item">
                <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="nav-link dropdown-toggle"><span data-feather="shopping-cart"></span> Shop</a>
                  <ul class="collapse list-unstyled" id="pageSubmenu2">
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'createcategory' ? ' active' : '' ?>" href="/admin/products/createCategory?action=createcategory"><span data-feather="layers"></span> &nbsp;&nbsp;Create Category</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'createsubcategory' ? ' active' : '' ?>" href="/admin/products/createSubCategory?action=createsubcategory"><span data-feather="list"></span> &nbsp;&nbsp;Sub Category</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'create' ? ' active' : '' ?>" href="/admin/products/create?action=create"><span data-feather="shopping-bag"></span> &nbsp;&nbsp;Insert Product</a>
                    </li>
                    <li>
                      <a class="dropdown-item <?= isset($_GET['action']) && $_GET['action'] == 'browseproducts' ? ' active' : '' ?>" href="/admin/products?action=browseproducts"><span data-feather="edit"></span> &nbsp;&nbsp;Manage Products</a>
                    </li>
                   </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == '#' ? ' active' : '' ?>" href="#">
                  <span data-feather="file-text"></span>
                  News
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'games' ? ' active' : '' ?>" href="/admin/games/create?action=games">
                  <span data-feather="airplay"></span>
                  Games
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Credits</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'scratchcards' ? ' active' : '' ?>" href="/admin/scratchcards?action=scratchcards">
                  <span data-feather="credit-card"></span>
                  Scratch Cards
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Charges</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'charges' ? ' active' : '' ?>" href="/admin/charges/create?action=charges">
                  <span data-feather="dollar-sign"></span>
                  Charges
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