module.exports = [
  {
    name: "lodash",
    deps: ["~lodash/lodash"],
  },
  {
    name: "main",
    deps: ["~jquery/dist/jquery.min", "vendor/my-lib"],
    files: ["components/foo", "components/bar"],
  },
];
