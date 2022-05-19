<template>
  <div class="container" data-app>
    <v-row>
      <v-col>
        <v-card
          class="mx-auto"
          max-width="1200"
        >
          <v-card-title class="teal lighten-4 white--text">
            <v-row class="mb-2 ml-2 mt-2 align-end">
              <v-btn
                class="mt-2"
                @click="openModalRecipient"
              >
                Dodaj użytkownika
              </v-btn>
          </v-row>
          </v-card-title>

            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
              class="mb-3 mx-2 pt-0"
            ></v-text-field>

            <v-data-table
              :headers="headers"
              :items="recipients"
              class="elevation-1"
              :search="search"
            >
              <template
                v-for="(header, i) in headers"
                v-slot:[getScope(header.value)]="{ item }"
              >
                <div :key="i">
                  <v-btn
                    v-if="header.onBtn"
                    @click="header.onClick( item )"
                  >
                    {{ header.value }}
                  </v-btn>
                  <span
                    v-else-if="header.date"
                    :class="header.class"
                  > {{ item[header.value] | formatDate }}</span>
                  <span
                    v-else
                    :class="header.class"
                  > {{ item[header.value] }}</span>
                </div>
              </template>
            </v-data-table>
        </v-card>
      </v-col>
    </v-row>

    <recipient-info-modal
      v-model="dialogRecipient"
      :editItem="editItem"
      @close-modal="closeModalRecipient"
      @load-recipients="loadRecipients"
    />
  </div>
</template>

<script>
import RecipientInfoModal from "../Modals/RecipientInfoModal";

export default {
  name: "RecipientsPage",
  components: {
    RecipientInfoModal,
  },
  data() {
    return {
      recipients: [],
      dialogRecipient: false,
      search: '',
      editItem: ''
    }
  },
  created() {
    this.loadRecipients()
  },
  watch: {},
  computed: {
     headers() {
      let headers = [
        { text: 'name', value: 'user_name'},
        { text: 'bank', value: 'bank'},
        { text: 'email', value: 'email'},
        { text: 'date', value: 'created_at', date: true},
        { text: '', value: 'Del', onBtn: true, onClick: this.delRecipient, sortable: false},
        { text: '', value: 'Edit', onBtn: true, onClick: this.setEditItem, sortable: false},
      ]
      return headers
    }
  },
  methods: {
    getScope(name) {
      return 'item.' + name;
    },
    loadRecipients() {
      axios
        .get('/recipients/getUsers').then(response => {
            this.recipients = response.data;
          })
          .catch(error => {
            console.error(error);
          });
    }, 
    delRecipient(item) {
      axios({
        method: 'post',
        url: 'recipients/deleteRecipient/' + item.id,
        data: {},
      }).then(func => {
        this.loadRecipients()
      })
      .catch(error => {
        console.error(error);
      });
    },
    setEditItem(item){
      this.editItem = item
      this.openModalRecipient()
    },    
    openModalRecipient() {
      this.dialogRecipient = true
      
    },
    closeModalRecipient() {
      this.dialogRecipient = false
    },
  }
}
</script>
