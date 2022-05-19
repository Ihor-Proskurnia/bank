<template>
  <v-dialog
    v-model="value"
    width="500"
    @click:outside="closeModal()"
  >
    <v-card>
      <v-card-title
        class="subtitle-1 teal lighten-4 white--text"
      >
        <span>Add Recipient</span>
      </v-card-title>

      <v-card-text>

        <v-text-field
          v-model="recipientName"
          label="Recipient Name"
          :rules="[rules.required]"
        ></v-text-field>

        <v-autocomplete
          v-model="bank"
          :items="banks"
          item-text="item"
          item-value="id"
          label="Bank"
          :rules="[rules.required]"
        ></v-autocomplete>

        <v-text-field
          v-model="cash"
          type="number"
          append-icon="mdi-currency-usd"
          single-line
          :rules="[rules.required]"
        ></v-text-field>

        <v-text-field
          v-model="email"
          label="Email"
          :rules="[rules.required]"
        ></v-text-field>

        <v-text-field
          v-model="password"
          label="password"
          :rules="[rules.required]"
        ></v-text-field>

        <v-alert
          v-if="!enough"
          type="error"
          class="mt-6"
        >Please fill in all the fields correctly!</v-alert>

      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="closeModal()"
        >
          Cancel
        </v-btn>
        <v-btn
          v-if="editItem"
          text
          @click="checkEnoughEdit()"
          color="success"
        >
          Save
        </v-btn>
        <v-btn
          v-else
          text
          @click="checkEnoughAdd()"
          color="success"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "RecipientInfoModal",
  props: {
    value:{
      type: Boolean,
      required: true
    },
    editItem:{}
  },
  data: () => ({
    recipientName: '',
    bank: '',
    cash: null,
    email: '',
    password: '',
    banks: ['PKO', 'mBank', 'Santander'],
    rules: {
      required: value => !!value || 'Required.',
    },
    enough: true
  }),
   computed: {
   },
  watch: {
    editItem: {
      handler () {
        this.checkEditItem()
      },
      deep: true,
    }
  },
  methods: {
    closeModal() {
      this.recipientName = '',
      this.bank = '',
      this.cash= null,
      this.email = '',
      this.password = '',
      this.$emit('close-modal')
    },
    addRecipient() {
      axios({
        method: 'post',
        url: 'recipients/addRecipient',
        data: {
          name: this.recipientName,
          bank: this.bank,
          cash: this.cash,
          email: this.email,
          password: this.password
        },
      }).then(func => {
        this.closeModal()
        this.$emit('load-recipients')
      })
      .catch(error => {
        console.error(error);
      });
    },
    checkEditItem() {
      if(this.editItem) {
        this.recipientName = this.editItem.user_name,
        this.bank = this.editItem.bank,
        this.cash = this.editItem.bank_account,
        this.email = this.editItem.email,
        this.password = this.editItem.password
      }
    },
    editRecipient() {
      axios({
        method: 'post',
        url: 'recipients/editRecipient/' + this.editItem.id,
        data: {
          name: this.recipientName,
          bank: this.bank,
          email: this.email,
          password: this.password
        },
      }).then(func => {
        this.closeModal()
        this.$emit('load-recipients')
      })
      .catch(error => {
        console.error(error);
      });
    },
    checkEnoughAdd(){
      if(this.recipientName && this.bank && this.email && this.password && this.cash) {
        this.addRecipient()
      } else {
        this.enough = false
      }
    },
    checkEnoughEdit(){
      if(this.recipientName && this.bank && this.email && this.password) {
        this.editRecipient()
      } else {
        this.enough = false
      }
    }
  },
}
</script>