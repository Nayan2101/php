const express = require("express");
const ejs = require("ejs");
const app = express();
const path = require("path");
const port = process.env.port || 8080;
require("./database/conn");

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.set("views", path.join(__dirname, "views"));
app.set("view engine", "ejs");

const userroute = require("./routers/user.routes");
app.use("/student", userroute);
app.listen(port, () => {
  console.log(`server listen on ${port}`);
});
