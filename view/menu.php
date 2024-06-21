<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel"  data-bs-theme="dark">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-warning" id="offcanvasMenuLabel">NoteApp</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
      <li class="nav-item">
        <a href="viewnotes" class="nav-link">
          <span class="ms-1 text-white">My notes</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="openNote/search" class="nav-link">
          <span class="ms-1 text-white">Search</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="viewarchives" class="nav-link">
          <span class="ms-1 text-white">My archives</span>
        </a>
      </li>
      <?php for ($i = 0; $i < sizeof($sharedBy); $i++):?>
        <li class="nav-item">
          <a href="viewsharednotes/sharedby/<?= $sharedBy[$i] ?>" class="nav-link">
            <span class="ms-1 text-white">Shared by <?= $nameSharedBy[$i] ?></span>
          </a>
        </li>
      <?php endfor ?>
      <li class="nav-item">
        <a href="settings" class="nav-link">
          <span class="ms-1 text-white">Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="session1" class="nav-link">
          <span class="ms-1 text-white">Session 1</span>
        </a>
      </li>
    </ul>
  </div>
</div>