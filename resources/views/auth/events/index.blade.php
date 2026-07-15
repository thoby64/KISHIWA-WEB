@extends('layouts.app')

@section('title', 'Events Management - Little Stars Daycare and Nursery School')

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
        <h1 class="display-2 text-white animated slideInDown mb-4">Events Management</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Events</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Events Management Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Events</h3>
                        <a href="{{ route('auth.events.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Add New Event
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <!-- Search and Filters Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" action="{{ route('auth.events.index') }}" class="mb-0">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">Search Events</label>
                                        <input type="text" class="form-control" id="search" name="search" 
                                               placeholder="Search by title, description, location..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Filter by Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All Status</option>
                                            @foreach($statuses as $value => $label)
                                                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="category" class="form-label">Filter by Category</label>
                                        <select class="form-select" id="category" name="category">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label for="sort" class="form-label">Sort By</label>
                                        <select class="form-select" id="sort" name="sort">
                                            <option value="event_date" {{ request('sort', 'event_date') === 'event_date' ? 'selected' : '' }}>Event Date</option>
                                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                                            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                                            <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="order" class="form-label">Order</label>
                                        <select class="form-select" id="order" name="order">
                                            <option value="asc" {{ request('order', 'asc') === 'asc' ? 'selected' : '' }}>Ascending</option>
                                            <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Descending</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-flex gap-2 pt-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search me-2"></i>Search
                                            </button>
                                            <a href="{{ route('auth.events.index') }}" class="btn btn-secondary">
                                                <i class="fa fa-refresh me-2"></i>Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bulk Actions Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="bulkActionForm" method="POST" action="{{ route('auth.events.bulk-update') }}">
                                @csrf
                                
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-6">
                                        <label for="bulkAction" class="form-label">Bulk Actions</label>
                                        <select class="form-select" id="bulkAction" name="action">
                                            <option value="">-- Select Action --</option>
                                            <option value="publish">Publish Selected</option>
                                            <option value="draft">Move to Draft</option>
                                            <option value="cancel">Cancel Selected</option>
                                            <option value="delete">Delete Selected</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-warning" id="bulkActionBtn" onclick="submitBulkAction()">
                                            <i class="fa fa-cogs me-2"></i>Apply to Selected
                                        </button>
                                    </div>
                                </div>

                                <!-- Container for hidden inputs to hold selected IDs -->
                                <div id="selectedIdsContainer"></div>

                                <!-- Events Table -->
                                <div class="table-responsive mt-4">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" id="selectAll" class="form-check-input" onclick="toggleSelectAll(this)">
                                                </th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($events as $event)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input event-checkbox" value="{{ $event->id }}">
                                                </td>
                                                <td>
                                                    @if($event->hasFeaturedImage())
                                                        <img src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                            <i class="fa fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $event->title }}</strong></td>
                                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                                <td>{{ $event->event_time ? $event->event_time->format('h:i A') : 'N/A' }}</td>
                                                <td>{{ $event->location ?: 'N/A' }}</td>
                                                <td>
                                                    @switch($event->status)
                                                        @case('published')
                                                            <span class="badge bg-success">Published</span>
                                                            @break
                                                        @case('draft')
                                                            <span class="badge bg-warning text-dark">Draft</span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="badge bg-danger">Cancelled</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-info">Completed</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">{{ ucfirst($event->status) }}</span>
                                                    @endswitch
                                                    @if($event->category)
                                                        <br>
                                                        <span class="badge mt-2" style="background-color: {{ $event->category->color }}; font-size: 11px;">
                                                            {{ $event->category->name }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $event->creator->name ?? 'System' }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('auth.events.edit', $event) }}" class="btn btn-outline-primary" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-outline-danger btn-delete-event" title="Delete"
                                                            data-id="{{ $event->id }}" data-event-title="{{ $event->title }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">No events found. Try adjusting your filters.</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $events->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Events Management End -->

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
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.event-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.event-checkbox:checked');
    const selectAllCheckbox = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.event-checkbox');
    
    selectAllCheckbox.checked = checkboxes.length === allCheckboxes.length && allCheckboxes.length > 0;
}

function submitBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const checkboxes = document.querySelectorAll('.event-checkbox:checked');
    
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    if (checkboxes.length === 0) {
        alert('Please select at least one event');
        return;
    }

        if (action === 'delete') {
        // show modal confirmation for bulk delete
        showConfirmModal('Delete Events', 'Are you sure you want to delete ' + checkboxes.length + ' event(s)? This action cannot be undone.', function() {
            const ids = Array.from(checkboxes).map(cb => cb.value);
            // clear previous inputs
            const container = document.getElementById('selectedIdsContainer');
            container.innerHTML = '';
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'event_ids[]';
                input.value = id;
                container.appendChild(input);
            });
            document.getElementById('bulkActionForm').submit();
        });

        return;
    }

    const ids = Array.from(checkboxes).map(cb => cb.value);
    const container = document.getElementById('selectedIdsContainer');
    container.innerHTML = '';
    ids.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'event_ids[]';
        input.value = id;
        container.appendChild(input);
    });
    document.getElementById('bulkActionForm').submit();
}

// Add event listener to checkboxes
document.querySelectorAll('.event-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

    // Base URL for events (used to construct delete URL)
    const baseEventsUrl = "{{ url('auth/events') }}";

    // Handle single event delete via modal using fetch to avoid nested form issues
    document.querySelectorAll('.btn-delete-event').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-event-title') || 'this event';
            const url = id ? (baseEventsUrl + '/' + id) : null;
            showConfirmModal('Delete Event', 'Are you sure you want to delete "' + title + '"? This action cannot be undone.', function() {
                if (!url) {
                    alert('Delete URL not available');
                    return;
                }
                sendDeleteRequest(url);
            });
        });
    });

    function sendDeleteRequest(url) {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.getAttribute('content') : null;
        if (!url) {
            showToast('Delete URL is not available.', 'danger');
            return;
        }

        // Debug: log URL
        console.debug('Deleting event URL:', url);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        }).then(async response => {
            if (response.ok) {
                showToast('Event deleted successfully.', 'success');
                setTimeout(() => window.location.reload(), 700);
                return;
            }

            // If DELETE not allowed, try POST fallback with _method=DELETE
            if (response.status === 405) {
                const ok = await fallbackPostDelete(url, token);
                if (ok) {
                    showToast('Event deleted successfully.', 'success');
                    setTimeout(() => window.location.reload(), 700);
                    return;
                }
            }

            let text = await response.text();
            try { text = JSON.parse(text).message ?? text; } catch(e) {}
            showToast('Failed to delete event: ' + (text || 'Unknown error'), 'danger');
        }).catch(err => {
            showToast('Error deleting event: ' + err.message, 'danger');
        });
    }

    async function fallbackPostDelete(url, token) {
        // Send a POST with _method=DELETE to support servers that block direct DELETE
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

    // Simple toast helper using Bootstrap alerts appended to top-right
    function showToast(message, level = 'info') {
        const containerId = 'toastContainer';
        let container = document.getElementById(containerId);
        if (!container) {
            container = document.createElement('div');
            container.id = containerId;
            container.style.position = 'fixed';
            container.style.top = '1rem';
            container.style.right = '1rem';
            container.style.zIndex = 2000;
            document.body.appendChild(container);
        }

        const alert = document.createElement('div');
        alert.className = `alert alert-${level} alert-dismissible fade show`;
        alert.role = 'alert';
        alert.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
        container.appendChild(alert);

        setTimeout(() => {
            try { alert.classList.remove('show'); alert.classList.add('fade'); } catch(e) {}
            setTimeout(() => alert.remove(), 500);
        }, 3500);
    }

    // Generic confirm modal helper
    function showConfirmModal(title, message, onConfirm) {
        let modal = document.getElementById('confirmModal');
        if (!modal) {
            // create modal markup
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
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
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
        const handler = function() {
            bsModal.hide();
            okBtn.removeEventListener('click', handler);
            onConfirm && onConfirm();
        };
        okBtn.addEventListener('click', handler);
    }
</script>
@endsection
