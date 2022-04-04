import axios from 'axios';

export default {
    fetchUsers(type){
        // console.log(type);
        return axios.get(`${window.application_root_api}/users?type=${type}`).catch(() => alert('Something Wrong!'));
    }
}
