// Be sure to replace empty strings with your own App's Publish & Subscribe keys
// otherwise the demo keys will be used.
let userPubKey = '' || 'pub-c-fbd238e6-ab67-4e42-946a-9f5e9f8b5628';
let userSubKey = '' || 'sub-c-147b4dd8-786f-11e8-9f59-fec9626a7085';
// Make a jQuery sort for the chat log based on message timetoken (tt)s
jQuery.fn.sortDomElements = (function() {
    return function(comparator) {
        return Array.prototype.sort.call(this, comparator).each(function(i) {
              this.parentNode.appendChild(this);
        });
    };
})();

var generatePerson = function(online) {

    var person = {};

    person.first = $('#username').val();

    person.uuid = $('#id').val();

    person.online = online || false;

    return person;

}

var app = {
    messageToSend: '',
    ChatEngine: false,
    me: false,
    chat: false,
    users: [],
    messages: [],
    init: function() {
        // Make sure to import ChatEngine first!
        this.ChatEngine = ChatEngineCore.create({
            publishKey: userPubKey,
            subscribeKey: userSubKey
        });

        let newPerson = generatePerson(true);

        this.ChatEngine.connect(newPerson.uuid, newPerson);

        this.cacheDOM();

        this.ChatEngine.on('$.ready', function(data) {
            app.ready(data);
            app.bindMessages();
        });

    },
    ready: function(data) {
        this.me = data.me;
        this.chat = new this.ChatEngine.Chat('admin-chat');
        const emoji = ChatEngineCore.plugin['chat-engine-emoji']();
         this.chat.plugin(emoji);
         // UNCOMMENT code below to leverage PubNub's MSG History feature
         this.chat.on('$.connected', () => {
             // search for 50 old `message` events
             this.chat.search({
                 'reverse': true,
                 event: 'message',
                 limit: 50
             }).on('message', (data) => {
               // when messages are returned, render them like normal messages
               app.renderMessage(data, true);
             }).plugin(emoji);
         });
        this.bindEvents();
    },
    cacheDOM: function() {
        this.$chatHistory = $('.chat-history');
        this.$button = $('#send');
        this.$textarea = $('#message-to-send');
        this.$chatHistoryList = this.$chatHistory.find('ul');
    },
    bindEvents: function() {

        this.$button.on('click', this.sendMessage.bind(this));
        this.$textarea.on('keyup', this.sendMessageEnter.bind(this));

    },
    bindMessages: function() {

        this.chat.on('message', function(message) {
            app.renderMessage(message);
        });

    },
    renderMessage: function(message) {

        var meTemp = Handlebars.compile($("#message-template").html());
        var userTemp = Handlebars.compile($("#message-response-template").html());

        var template = userTemp;

        if (message.sender.uuid == app.me.uuid) {
            template = meTemp;
        }

        // Converts PubNub timetoken to JS date time. ChatEngine 0.9+ only.
        var messageJsTime = new Date(parseInt(message.timetoken.substring(0,13)));

        var context = {
            messageOutput: message.data.text,
            tt: messageJsTime.getTime(),
            time: app.parseTime(messageJsTime),
            user: message.sender.state
        };

        app.$chatHistoryList.append(template(context));

        // Sort messages in chat log based on their timetoken (tt)
        app.$chatHistoryList
        .children()
        .sortDomElements(function(a,b){
            akey = a.dataset.order;
            bkey = b.dataset.order;
            if (akey == bkey) return 0;
            if (akey < bkey) return -1;
            if (akey > bkey) return 1;
        });
        $('.emoji').css('height', '26px');
        $('.emoji').parents('.message').css({"padding-top": "9px","padding-bottom": "9px"});
        this.scrollToBottom();

    },
    sendMessage: function() {

        this.messageToSend = this.$textarea.val()

        if (this.messageToSend.trim() !== '') {
            this.$textarea.val('');
            this.chat.emit('message', {
                text: this.messageToSend
            });
        }

    },
    sendMessageEnter: function(event) {

        // enter was pressed
        if (event.keyCode === 13) {
            this.sendMessage();
        }
    },
    scrollToBottom: function() {
      //neraboti
        this.$chatHistory.scrollTop(this.$chatHistory[0].scrollHeight);
    },
    parseTime: function(time) {
        return time.toLocaleDateString() + ", " + time.toLocaleTimeString().
        replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
    },
    getCurrentTime: function() {
        return new Date().toLocaleTimeString().
        replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
    },
    getRandomItem: function(arr) {
        return arr[Math.floor(Math.random() * arr.length)];
    }

};

app.init();
