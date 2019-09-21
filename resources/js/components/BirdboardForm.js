class BirboardForm {

  constructor(data){
    this.originalData = JSON.parse(JSON.stringify(data));
    this.errors = [];
    this.submitted = false;

    this.reset();
  }

  data(){
    return Object.keys(this.originalData).reduce((data, attribute) => {
      data[attribute] = this[attribute];

      return data;
    }, {});
  }

  submit(endpoint){
    return axios.post(endpoint, this.data())
      .catch(this.onFail.bind(this))
      .then(this.onSuccess.bind(this))
  }

  onFail(error){
    this.errors = error.response.data.errors;
    this.submitted = false;

    throw error;
  }

  onSuccess(response){
    this.submitted = true;
    this.errors = {};

    return response;
  }

  reset(){
    Object.assign(this, this.originalData);
  }
}

export default BirboardForm;