<template>
  <div class="card">
      <div class="card-header">{{ otherUser.name }}</div>
      <div class="card-body">
          <div v-for="message in messages" :key="message.id">
              <div
                  :class="{ ' text-success text-right': message.author === authUser.email }"
              >
                  {{ message.body }} {{ message.author }}
              </div>
          </div>
      </div>
      <div class="card-footer">
      <input
        type="text"
        v-model="newMessage"
        class="form-control"
        placeholder="Type your message..."
        @keyup.enter="sendMessage"
        @keydown="typingIndicator"
      />
    </div>
  </div>
</template>

<script>
  export default {
    name: "ChatComponent",
    props: {
      authUser: {
        type: Object,
        required: true
      },
      otherUser: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        messages: [],
        newMessage: "",
        channel: "",
        ch: this.generateChannel(),
      };
    },
    async created() {
     
      this.ch = this.generateChannel();
      const token = await this.fetchToken();
      await this.initializeClient(token);
      await this.fetchMessages();
    },
    
    methods: {
      async fetchToken() {
        const { data } = await axios.post("/api/token", {
          email: this.authUser.email
        });
        return data.token;
      },
      async initializeClient(token) {
        const client = await Twilio.Chat.Client.create(token);
        client.on("tokenAboutToExpire", async () => {
          const token = await this.fetchToken();
          client.updateToken(token);
        });
        this.channel = await client.getChannelByUniqueName(
          this.ch
        );
        this.channel.on("messageAdded", message => {
          this.messages.push(message);
        });

      //   this.channel.getMessages().then(function(messages) {
      //     const totalMessages = messages.items.length;
      //     for (var i = 0; i < totalMessages; i++) {
      //       const message = messages.items[i];
      //       console.log('Author:' + message.author);
      //     }
      //     console.log('Total Messages:' + totalMessages);
      // });

      this.channel.on('typingStarted', function(member) {
        this.updateTypingIndicator(member, true);
      });

      },
      generateChannel(){
        let ch = '';
        if(this.authUser.id < this.otherUser.id){
          ch = this.authUser.id+'-'+this.otherUser.id;
        }else{
          ch = this.otherUser.id+'-'+this.authUser.id;
        }
        // console.log('ch');
        return ch;
      },
      async fetchMessages() {
        this.messages = (await this.channel.getMessages()).items;
      },
      sendMessage() {
        this.channel.sendMessage(this.newMessage);
        this.newMessage = "";
      },
      typingIndicator(e){
        if (e.keyCode === 13) {
          // sendButton.click();
        } else {
          // var members = this.channel.getMembers()
          // members.then(function(currentMembers) {
          //     currentMembers.forEach(function(member) {
          //         updateTypingIndicator(member);
          //     });
          // });
          
          this.channel.typing();
        }
      },
      async updateTypingIndicator(member){
        console.log(member)
      }
  

    }
  };
</script>
