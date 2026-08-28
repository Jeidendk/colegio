document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) window.lucide.createIcons();
    const password = document.querySelector('[data-login-password]');
    document.querySelector('[data-toggle-password]')?.addEventListener('click', (event) => {
        const visible = password?.type === 'text';
        if (password) password.type = visible ? 'password' : 'text';
        event.currentTarget.innerHTML = `<i data-lucide="${visible ? 'eye' : 'eye-off'}"></i>`;
        if (window.lucide) window.lucide.createIcons();
    });
    const toast = document.querySelector('.school-login-toast');
    document.querySelector('[data-login-help]')?.addEventListener('click', () => {
        toast?.classList.add('is-visible');
        window.setTimeout(() => toast?.classList.remove('is-visible'), 2600);
    });
});
