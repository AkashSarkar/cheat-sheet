<template>
  <v-select
    v-model="selectedAirline"
    :options="airlines"
    @search="onSearch"
    :disabled="disableEdit"
  ></v-select>
</template>
<script>
import vSelect from "vue-select";
export default {
  components: { vSelect },
  data() {
    return {
      airlines: [],
      selectedAirline: ""
    };
  },
  methods: {
    onSearch(search, loading) {
      loading(true);
      this.searchAirlines(loading, search, this);
    },
    searchAirlines: _.debounce((loading, search, vm) => {
      let url = BaseUrl + `search-airlines?q=${escape(search)}`;
      fetch(url).then(res => {
        res.json().then(json => {
          vm.airlines = json.airlines;
        });
        loading(false);
      });
    }, 500),
    getAirlines() {
      let url = BaseUrl + "airlines";
      axios.get(url).then(res => {
        this.airlines = res.data.airlines;
      });
    }
  }
};
</script>

