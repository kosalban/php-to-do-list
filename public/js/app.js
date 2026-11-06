/**
 * Simple Todo List Application - Vanilla JavaScript Client
 */

document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------------------
    // 1. Theme Management (Light / Dark Mode with Persistence)
    // -------------------------------------------------------------------------
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeIcon = document.getElementById('themeIcon');
    const storedTheme = localStorage.getItem('todo_app_theme');

    const getPreferredTheme = () => {
        if (storedTheme) {
            return storedTheme;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    };

    const setTheme = (theme) => {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('todo_app_theme', theme);

        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill text-warning';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill text-secondary';
            }
        }
    };

    // Initialize theme immediately
    setTheme(getPreferredTheme());

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function () {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });
    }

    // -------------------------------------------------------------------------
    // 2. Mobile Sidebar Toggle & Backdrop
    // -------------------------------------------------------------------------
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const appSidebar = document.getElementById('appSidebar');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    if (sidebarToggleBtn && appSidebar) {
        sidebarToggleBtn.addEventListener('click', function () {
            appSidebar.classList.toggle('show');
            if (sidebarBackdrop) {
                sidebarBackdrop.classList.toggle('show');
            }
        });
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', function () {
            if (appSidebar) appSidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
        });
    }

    // -------------------------------------------------------------------------
    // 3. Delete Confirmation Dialog / Modal Handling
    // -------------------------------------------------------------------------
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    if (deleteModalEl) {
        deleteModalEl.addEventListener('show.bs.modal', function (event) {
            const triggerBtn = event.relatedTarget;
            if (!triggerBtn) return;

            const taskTitle = triggerBtn.getAttribute('data-task-title') || 'this task';
            const actionUrl = triggerBtn.getAttribute('data-action-url') || '';

            const titlePlaceholder = deleteModalEl.querySelector('#deleteModalTaskTitle');
            const deleteForm = deleteModalEl.querySelector('#deleteTaskForm');

            if (titlePlaceholder) {
                titlePlaceholder.textContent = taskTitle;
            }

            if (deleteForm && actionUrl) {
                deleteForm.setAttribute('action', actionUrl);
            }
        });
    }

    // -------------------------------------------------------------------------
    // 4. Auto-initialize and Show Bootstrap Toasts
    // -------------------------------------------------------------------------
    const toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 4500,
        });
        toast.show();
    });
});

