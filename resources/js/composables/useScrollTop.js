export function useScrollTop() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
}