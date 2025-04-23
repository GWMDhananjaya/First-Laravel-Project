<template>
  <div class="container">
    <h3 align="center" class="mt-5">Student Management</h3>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="form-area">
          <form id="check-register-form" @submit.prevent="save">
            <div class="row">
              <div class="col-md-6">
                <label>Student Name</label>
                <v-text-field
                  v-model="student.name"
                  label="Student Name"
                  required
                ></v-text-field>
              </div>

              <div class="col-md-6">
                <label>Student Address</label>
                <v-text-field
                  v-model="student.address"
                  label="Student Address"
                  required
                >
                </v-text-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Phone</label>
                <v-text-field
                  v-model="student.phone"
                  label="Student Address"
                  required
                >
                </v-text-field>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-3">
                <v-btn type="submit" color="success" form="check-register-form"
                  >Save</v-btn
                >
              </div>
            </div>
          </form>
        </div>

        <v-table theme="dark">
          <thead>
            <tr>
              <th class="text-left">Student ID</th>
              <th class="text-left">Student Name</th>

              <th class="text-left">Address</th>

              <th class="text-left">Phone</th>
              <th class="text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="student in result" :key="student.id">
              <td>{{ student.id }}</td>
              <td>{{ student.name }}</td>
              <td>{{ student.address }}</td>
              <td>{{ student.phone }}</td>
              <td>
                <v-btn type="button" color="info" @click="edit(student)"
                  >Edit</v-btn
                >

                <v-btn type="button" color="danger" @click="remove(student)"
                  >Delete</v-btn
                >
              </td>
            </tr>
          </tbody>
        </v-table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "redaxios";

export default {
  name: "Student",
  data() {
    return {
      result: {},
      student: {
        id: "",
        name: "",
        address: "",
        phone: "",
      },
    };
  },
  created() {
    this.StudentLoad();
  },
  mounted() {
    console.log("mounted() called.......");
  },

  methods: {
    StudentLoad() {
      var page = "http://127.0.0.1:8000/api/student";
      axios.get(page).then(({ data }) => {
        console.log(data);
        this.result = data;
      });
    },

    save() {
      if (this.student.id == "") {
        this.saveData();
      } else {
        this.updateData();
      }
    },
    saveData() {
      axios
        .post("http://127.0.0.1:8000/api/student", this.student)
        .then(({ data }) => {
          this.StudentLoad();
          this.student.name = "";
          (this.student.address = ""), (this.student.phone = "");
          this.id = "";
        });
    },
    edit(student) {
      this.student = student;
    },
    updateData() {
      var editrecords = "http://127.0.0.1:8000/api/student/" + this.student.id;
      axios.put(editrecords, this.student).then(({ data }) => {
        this.student.name = "";
        (this.student.address = ""), (this.student.phone = "");
        this.id = "";
        alert("Updated!!!");
        this.StudentLoad();
      });
    },

    remove(student) {
      var url = `http://127.0.0.1:8000/api/student/${student.id}`;

      axios.delete(url);
      alert("Deleteddd");
      this.StudentLoad();
    },
  },
};
</script>

<style scoped>
.form-area {
  padding: 20px;
  margin-top: 20px;
  background-color: #0b0b0b;
  color: #fffcfc;
}
.bi-trash-fill {
  color: red;
  font-size: 18px;
}
.bi-pencil {
  color: green;
  font-size: 18px;
  margin-left: 20px;
}
</style>
