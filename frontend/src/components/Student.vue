<template>
  <div class="container py-6">
    <v-card class="mx-auto max-w-4xl pa-6 elevation-3">
      <h2 class="text-center mb-6">Add Student</h2>

      <!-- Form Section -->
      <v-form @submit.prevent="save" id="student-form">
        <v-row dense>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="student.name"
              label="Student Name"
              outlined
              dense
              required
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="student.address"
              label="Student Address"
              outlined
              dense
              required
            />
          </v-col>

          <v-col cols="12">
            <v-text-field
              v-model="student.phone"
              label="Phone Number"
              outlined
              dense
              required
            />
          </v-col>

          <v-col cols="12" class="text-center">
            <v-btn
              type="submit"
              color="success"
              class="mt-3"
              prepend-icon="mdi-content-save"
            >
              {{ student.id ? "Update" : "Save" }}
            </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>

    <!-- Student List Table -->
    <v-card class="mx-auto max-w-6xl mt-8 elevation-3">
      <v-card-title class="text-h6 text-center">📋 Student List</v-card-title>
      <v-data-table
        :headers="headers"
        :items="result"
        class="elevation-1"
        dense
      >
        <template v-slot:item.action="{ item }">
          <v-btn icon color="info" @click="edit(item)">
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
          <v-btn icon color="error" @click="remove(item)">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>

<script>
import axios from "redaxios";

export default {
  name: "Student",
  data() {
    return {
      result: [],
      student: {
        id: "",
        name: "",
        address: "",
        phone: "",
      },
      headers: [
        { text: "ID", value: "id" },
        { text: "Name", value: "name" },
        { text: "Address", value: "address" },
        { text: "Phone", value: "phone" },
        { text: "Actions", value: "action", sortable: false },
      ],
    };
  },
  created() {
    this.StudentLoad();
  },
  methods: {
    StudentLoad() {
      axios.get("http://127.0.0.1:8000/api/student").then(({ data }) => {
        this.result = data;
      });
    },
    save() {
      this.student.id ? this.updateData() : this.saveData();
    },
    saveData() {
      axios.post("http://127.0.0.1:8000/api/student", this.student).then(() => {
        this.resetForm();
        this.StudentLoad();
      });
    },
    edit(student) {
      this.student = { ...student };
    },
    updateData() {
      axios
        .put(
          `http://127.0.0.1:8000/api/student/${this.student.id}`,
          this.student
        )
        .then(() => {
          this.resetForm();
          alert("Student Updated!");
          this.StudentLoad();
        });
    },
    remove(student) {
      axios
        .delete(`http://127.0.0.1:8000/api/student/${student.id}`)
        .then(() => {
          alert("Student Deleted!");
          this.StudentLoad();
        });
    },
    resetForm() {
      this.student = { id: "", name: "", address: "", phone: "" };
    },
  },
};
</script>

<style scoped>
.container {
  background-color: #f9f9f9;
}
</style>
