<nav class="navbar navbar-expand-lg ">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><?php echo lang('home_admin')?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link " aria-current="page" href="categories.php"> <?php echo lang('Categories')?></a></li> 
                    
                <li class="nav-item"><a class="nav-link " aria-current="page" href="items.php"> <?php echo lang('Items')?></a> </li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="members.php"> <?php echo lang('Members')?></a> </li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="comments.php"> <?php echo lang('Comments')?></a> </li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"> <?php echo lang('statistics')?></a> </li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"> <?php echo lang('Logs')?></a> </li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        seham
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                       <li><a class="dropdown-item" href="../index.php"> visit shop</a></li>
                        <li><a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['ID']?>"><?php echo lang('Edit_Profile')?></a></li>
                        <li><a class="dropdown-item" href="#"><?php echo lang('Settings')?></a></li>
                        <li><a class="dropdown-item" href="logout.php"> <?php echo lang('Logout')?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

