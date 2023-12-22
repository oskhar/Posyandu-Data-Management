<template>
  <div id="app">
    <div>
      <organization-chart :datasource="ds" @node-click="log">
        <template slot-scope="{ nodeData }">
          <div :class="['node-box', nodeData.id == '1' ? 'parent' : '']">
            <div class="node-title">{{ nodeData.name }}</div>
            <div class="node-content">
              <img width="25%" src="./assets/logo.png">
              <div>{{ nodeData.title }} {{ nodeData.id }}</div>
            </div>
          </div>
        </template>
      </organization-chart>
    </div>
  </div>
</template>

<script>
import OrganizationChart from "vue-organization-chart";
import "vue-organization-chart/dist/orgchart.css";

export default {
  name: "App",
  components: {
    OrganizationChart
  },
  data() {
    return {
      ds: {
        id: "1",
        name: "Lao Lao",
        title: "general manager",
        children: [
          { id: "2", name: "Bo Miao", title: "department manager" },
          {
            id: "3",
            name: "Su Miao",
            title: "department manager",
            children: [
              { id: "4", name: "Tie Hua", title: "senior engineer" },
              {
                id: "5",
                name: "Hei Hei",
                title: "senior engineer",
                children: [
                  {
                    id: "6",
                    name: "Pang Pang发斯蒂芬大厦法定身份",
                    title: "engineer\n阿萨德发发的顺丰"
                  },
                  {
                    id: "7",
                    name: "Xiang Xiang",
                    title: "UE engineer",
                    children: [
                      { id: "6", name: "Pang Pang", title: "engineer" },
                      { id: "7", name: "Xiang Xiang", title: "UE engineer" }
                    ]
                  }
                ]
              }
            ]
          },
          { id: "8", name: "Hong Miao", title: "department manager" },
          {
            id: "9",
            name: "Chun Miao",
            title: "department manager",
            children: [
              { id: "6", name: "Pang Pang", title: "engineer" },
              { id: "7", name: "Xiang Xiang", title: "UE engineer" }
            ]
          }
        ]
      }
    };
  },
  methods: {
    log(e) {
      console.log(e);
    }
  }
};
</script>

<style lang="scss">
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 10px;
}

.orgchart-container {
  height: 800px;
}

.orgchart {
  background: #000;
}

.node-box {
  border: 1px solid red;
  position: relative;

  &.parent::before {
    content: "";
    display: none;
  }
}

.node-title {
  background: #ccc;
}

.node-content {
  background-color: #fff;
  color: #000;
}

.node-box::before {
  content: "▼";
  position: absolute;
  top: -16px;
  left: 50%;
  color: red;
  margin-left: -8px;
}</style>
