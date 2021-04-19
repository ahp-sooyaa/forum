let user = window.App.user;

module.exports = {
    updateReply(reply){
        return reply.user_id == user.id
    },
    markBestReply(reply){
        return user.id == reply.thread.creator.id
    }
}