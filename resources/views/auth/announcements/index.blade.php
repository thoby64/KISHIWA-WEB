@extends('layouts.app')

@section('title', 'Announcements Management - Little Stars Daycare and Nursery School')

@section('content')
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('img/logo/littlestar.PNG') }}" alt="Little Stars Logo" style="height: 50px; margin-right: 10px;">
        <h1 class="m-0 text-primary" style="font-size: 1.2rem;">LITTLE STARS DAYCARE AND NURSERY SCHOOL</h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto">
            <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
            <a href="{{ route('about') }}" class="nav-item nav-link">About Us</a>
            <a href="{{ route('classes') }}" class="nav-item nav-link">Classes</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                    <a href="{{ route('appointment.create') }}" class="dropdown-item">Make Appointment</a>
                    <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
        </div>
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user me-2"></i>{{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('settings') }}" class="dropdown-item">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">Announcements Management</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Announcements</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Announcements Management Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Announcements</h3>
                        <a href="{{ route('auth.announcements.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Add New Announcement
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Announcements Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Created Date</th>
                                    <th>Urgent</th>
                                    <th>Status</th>
                                    <th>Published At</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                <tr>
                                    <td>
                                        @if($announcement->hasFeaturedImage())
                                            <img src="{{ $announcement->featured_image_url }}" alt="{{ $announcement->title }}" class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width:80px; height:60px;">
                                                <i class="fa fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $announcement->title }}</td>
                                    <td>{{ $announcement->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $announcement->is_urgent ? 'danger' : 'secondary' }}">
                                            {{ $announcement->is_urgent ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $announcement->is_published ? 'success' : 'warning' }}">
                                            {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $announcement->creator->name ?? 'System' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('auth.announcements.edit', $announcement) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-announcement" data-id="{{ $announcement->id }}" data-title="{{ $announcement->title }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No announcements found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Announcements Management End -->

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Little Stars Daycare and Nursery School</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('about') }}">Privacy</a>
                        <a href="{{ route('contact') }}">Terms</a>
                        <a href="{{ route('contact') }}">FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
@endsection

@section('scripts')
<script>
    const baseAnnouncementsUrl = "{{ url('auth/announcements') }}";

    document.querySelectorAll('.btn-delete-announcement').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title') || 'this announcement';
            const url = id ? (baseAnnouncementsUrl + '/' + id) : null;
            showConfirmModal('Delete Announcement', 'Are you sure you want to delete "' + title + '"? This action cannot be undone.', function() {
                if (!url) { showToast('Delete URL not available', 'danger'); return; }
                sendDeleteRequest(url);
            });
        });
    });

    function sendDeleteRequest(url) {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.getAttribute('content') : null;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        }).then(async response => {
            if (response.ok) {
                showToast('Announcement deleted successfully.', 'success');
                setTimeout(() => window.location.reload(), 700);
                return;
            }
            if (response.status === 405) {
                const ok = await fallbackPostDelete(url, token);
                if (ok) { showToast('Announcement deleted successfully.', 'success'); setTimeout(() => window.location.reload(), 700); return; }
            }
            let text = await response.text();
            try { text = JSON.parse(text).message ?? text; } catch(e) {}
            showToast('Failed to delete announcement: ' + (text || 'Unknown error'), 'danger');
        }).catch(err => {
            showToast('Error deleting announcement: ' + err.message, 'danger');
        });
    }

    async function fallbackPostDelete(url, token) {
        const form = new URLSearchParams();
        form.append('_method', 'DELETE');
        const resp = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: form.toString()
        });
        return resp.ok;
    }

    function showConfirmModal(title, message, onConfirm) {
        let modal = document.getElementById('confirmModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'confirmModal';
            modal.tabIndex = -1;
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"><p>${message}</p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmModalOk">Confirm</button>
                        </div>
                    </div>
                </div>`;
            document.body.appendChild(modal);
        } else {
            modal.querySelector('.modal-title').textContent = title;
            modal.querySelector('.modal-body p').textContent = message;
        }
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        const okBtn = modal.querySelector('#confirmModalOk');
        const handler = function() { bsModal.hide(); okBtn.removeEventListener('click', handler); onConfirm && onConfirm(); };
        okBtn.addEventListener('click', handler);
    }

    function showToast(message, level = 'info') {
        const containerId = 'toastContainer';
        let container = document.getElementById(containerId);
        if (!container) { container = document.createElement('div'); container.id = containerId; container.style.position = 'fixed'; container.style.top = '1rem'; container.style.right = '1rem'; container.style.zIndex = 2000; document.body.appendChild(container); }
        const alert = document.createElement('div');
        alert.className = `alert alert-${level} alert-dismissible fade show`;
        alert.role = 'alert';
        alert.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
        container.appendChild(alert);
        setTimeout(() => { try { alert.classList.remove('show'); alert.classList.add('fade'); } catch(e) {} setTimeout(() => alert.remove(), 500); }, 3500);
    }
</script>
@endsection