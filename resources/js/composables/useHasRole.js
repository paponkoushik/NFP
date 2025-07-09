export function useHasRole(...role) {
    return window.App.user.role.split(':').some(userRole => role.indexOf(userRole) > -1);
}