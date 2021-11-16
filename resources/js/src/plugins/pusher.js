import Pusher from 'pusher-js'
import Vue from "vue";

const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER
});

const observer = (channel, event, callback) => {
    const subscribe = pusher.subscribe(channel);

    subscribe.bind(event, function (data) {
        callback(data)
    });
}

Vue.prototype.$pusher = pusher
Vue.prototype.$observer = observer

export default pusher