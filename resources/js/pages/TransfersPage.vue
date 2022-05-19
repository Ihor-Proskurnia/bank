 <template>
  <div class="container" data-app>
    <v-row>
      <v-col>
        <v-card
          class="my-5 mx-auto"
          max-width="1200"
        >
          <v-card-title class="teal lighten-4 white--text" >Transfer {{ currentUser[0].user_name }}</v-card-title>
            <v-row>              
              <v-text-field
                v-model="cash"
                type="number"
                append-icon="mdi-currency-usd"
                single-line
                :rules="[rules.required]"
                class="ml-3 mb-3 mt-5 mx-3 pt-0 col-2"
              ></v-text-field>

              <span class="ml-3 mb-3 mt-5 mx-5 pt-0"><v-icon large>mdi-bank-transfer-in</v-icon></span>

              <v-select
                v-model="selectUser"
                return-object
                :items="users"
                :hint="`${selectUser.bank}`"
                item-text="user_name"
                append-icon="mdi-account-cash-outline"
                label="To"
                single-line
                fixed
                class="ml-3 mb-3 mt-5 mx-3 pt-0"
              ></v-select>

              <v-btn
                color="teal lighten-4"
                class="mb-3 mt-5 mx-4 pt-0 white--text"
                medium
                @click="checkEnough"
              >
                <v-icon>
                  mdi-send
                </v-icon>
              </v-btn>
            </v-row>
        </v-card>
        <v-alert
          v-if="!enough"
          type="error"
          class="mt-6"
        >
          There are not enough funds in your account or the recipient is not specified!
        </v-alert>
        <v-alert
          v-if="success"
          type="success"
        >Success</v-alert>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  name: "TransfersPage",
  
  components: {},
  mixins: [
  ],
  props: {
  },
  data() {
    return {
      users: [],
      search: 'Ihor',
      currentUser: [{
        user_name: ''
      }],
      selectUser: false,
      cash: 0,
      rules: {
        required: value => !!value || 'Required.',
      },
      enough: true,
      success: false
    }
  },
  created() {
    this.getCurrentUser()
    this.getUsers()
  },
  watch: {},
  methods: {
    getCurrentUser() {
      axios
        .get('/recipients/getCurrentUser').then(response => {
            this.currentUser = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    },
    getUsers() {
      axios
        .get('/recipients/getUsers').then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    },
    sendTransfer() {
      axios({
        method: 'post',
        url: '/recipients/sendTransfer',
        data: {
          selectUser: this.selectUser,
          cash: this.cash
        },
      }).then(func => {
        this.success = true
        setTimeout(function() {
          document.location.reload();
        }, 1000);
      })
      .catch(error => {
        console.error(error);
      });
    },
    checkEnough(){
      if(this.currentUser[0].bank_account >= this.cash && this.cash >0 && this.selectUser) {
        this.sendTransfer()
      } else {
        this.enough = false
      }
    }
  }
}
</script>
