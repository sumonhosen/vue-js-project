import api from '../../api/user'

const state = {
    users: [],
};

const getters = {
    users: state => state.users
};

const actions = {
    async fetchUsers({ commit }, type = 'user'){
        // console.log(type);
        const response = await api.fetchUsers(type);
        console.log(response.data);
        commit('setUsers', response.data);
    },
};

const mutations = {
    setUsers: (state, users) => {
        state.users = users.data;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
