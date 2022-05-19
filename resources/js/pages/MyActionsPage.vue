<template>
<v-app>
  <div data-app>
    <v-card
      class="mx-auto"
      max-width="1200"
    >
      <v-card-title class="teal lighten-4 white--text">
        <h3 class="title">Actions</h3>
      </v-card-title>
      <v-card-text>
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
          :items="notes"
          class="elevation-1"
          :search="search"
        ></v-data-table>
      </v-card-text>
    </v-card>
  </div>
</v-app>
</template>

<script>
export default {
  name: "ActionPage",
  data: () => ({
    notes: [],
    search: '',
  }),
  methods: {
    loadNotes() {
      axios
        .get('/recipients/getActions').then(response => {
            this.notes = response.data
          })
          .catch(error => {
            console.error(error);
          });
    },
  },
  created () {
    this.loadNotes()
  },
  computed: {
    headers() {
      let headers = [
        { text: 'ID', value: 'id', primary: true},
        { text: 'Note', value: 'note'},
        { text: 'Date', value: 'date'}
      ]
      return headers
    }
  }
}
</script>
