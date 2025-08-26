<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            <img src="{{ asset('images/bmti.png') }}" alt="Logo BMTI">
            <div class="navbar-links">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('permohonan') }}" class="active">Permohonan</a>
                <a href="{{ route('tracking') }}">Tracking</a>
            </div>
        </div>
        <div class="navbar-right">
            <div class="profile-icon">
                <i class="fa fa-user"></i>
            </div>
        </div>
    </div>
</div>