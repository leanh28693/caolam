export const Logout = () =>{
    localStorage.removeItem('user')
    window.location.reload();
}