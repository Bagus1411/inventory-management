<div class="d-flex"></div>
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary border-end overflow-auto"
    style="width: 250px;">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                Bara-Bara Group
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-2 text-muted">
                <span>Home</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('/') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="/">
                        <i data-feather="home"></i>
                        Dashboard
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-2 text-muted">
                <span>Master</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('master/items*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="/master/items">
                        <i data-feather="package" class="opacity-75"></i>
                        Items
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('master/category*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="/master/category">
                        <i data-feather="tag" class="opacity-75"></i>
                        Categories
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-2 text-muted">
                <span>In & Out</span>
            </h6>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('action/itemin*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="/action/itemin">
                        <i data-feather="download" class="opacity-75"></i>
                        Item In
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('action/itemout*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="/action/itemout">
                        <i data-feather="upload" class="opacity-75"></i>
                        Item Out
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-2 text-muted">
                <span>Sales</span>
            </h6>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('sales*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="{{ route('sales.index') }}">
                        <i data-feather="shopping-cart" class="me-2"></i>
                        Sales
                    </a>
                </li>
            </ul>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('customer*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="{{ route('customer.index') }}">
                        <i data-feather="user-check" class="opacity-75"></i>
                        Customer
                    </a>
                </li>
            </ul>

            <hr class="my-3" />

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-2 text-muted">
                <span>Administrator</span>
            </h6>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('profile*') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="{{ route('profile.edit') }}">
                        <i data-feather="user" class="opacity-75"></i>
                        Profile
                    </a>
                </li>
            </ul>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 rounded
                            {{ Request::is('user') ? 'bg-secondary-subtle text-dark fw-semibold' : 'text-secondary' }}"
                        href="{{ route('user.index') }}">
                        <i data-feather="users" class="opacity-75"></i>
                        Users & Add User
                    </a>
                </li>
            </ul>

            <hr class="my-3" />

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-2 text-muted">
                <span>GET OUTT!</span>
            </h6>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="nav-link d-flex align-items-center gap-2 text-secondary bg-transparent border-0">
                            <i data-feather="log-out" class="opacity-75"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
