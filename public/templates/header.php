<div class="container-fluid" id="header">
    <div class="navbar">
        <a href="index.php"><img src="public/images/logo/logo.png" class="header-logo" ><img></a>
        <nav class="m-auto">
            <ul id="menuitems">
                <li>
                    <a href="./?to=search&from=self">All Products</a>
                </li>
                <li class="nav-item">
                    <a href="?to=search&from=self&danhmuc%5B%5D=1&danhmuc%5B%5D=2&danhmuc%5B%5D=0" >Tops</a>
                </li>
                <li class="nav-item">
                    <a href="?to=search&from=self&danhmuc%5B%5D=4&danhmuc%5B%5D=3&danhmuc%5B%5D=5">Bottoms</a>
                </li>
                <li class="nav-item">
                    <a href="./?to=search&from=another&name=loai&value=3">Sale</a>
                </li>
                <li class="nav-item">
                    <a href="./?to=search&from=another&name=loai&value=4">Support</a>
                </li>
                <li class="nav-item">
                    <a href="./?to=search&from=another&name=loai&value=5">About us</a>
                </li>
            </ul>
        </nav>

        <div class="navbar action-menu">
            <div>
                <a href="./?to=login" title="Tài khoản">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                    </svg>
                </a>
            </div>
            <div class="action-search">
                <span class="search-icon" id="searchbtn" onClick="showsearchbar()" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
            </span>
            </div>
            <div class="action-cart">
                <a href="./?to=cart" title="Giỏ hàng">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                    </svg>
                </a>
            </div>
            <span class="menu-icon" onClick="menutoggle()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </span>
        </div>
        <div class="searchbar" id="search-bar">
            <button id="close-bar" onClick="hidesearchbar()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z" />
                    <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z" />
                </svg></button>
            <form class="d-flex justify-content-center">
                <input type="hidden" name="to" value="search">
                <input type="hidden" name="from" value="searchbar">
                <input type="text" name="key" class="search-box" id="searchbar" placeholder="Tìm kiếm">
                <button type="submit" class="search-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>

            </form>
        </div>
    </div>
</div>