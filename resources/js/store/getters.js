export default {
    getPostProgressUpload(state) {
        return state.postUploadProgress;
    },
    getUser(state) {
        return state.user;
    },
    getUnreadNotifications(state) {
        return state.unreadNotifications;
    },
    getUnreadMessages(state) {
        return state.unreadMessages;
    },
    getNewMessages(state) {
        return state.newMessages;
    },
    getMessages(state) {
        return state.messages;
    }
}