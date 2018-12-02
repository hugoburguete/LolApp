import React from 'react';
import axios from 'axios';

export default class SearchForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            summonerName: '',
        }
    }

    /**
     * Handles the search box input change event.
     * @param {Event} event 
     */
    onInputChange(event) {
        this.setState({
            summonerName: event.target.value,
        });
    }

    /**
     * Handles the form submission
     * 
     * @param {Event} event 
     */
    onFormSubmit(event) {
        event.preventDefault();
        this.props.onFormSubmit();
        this.requestSummoner(
            this.state.summonerName,
            (data) => {
                this.props.onSummonerFound(data);
            },
            (error) => {
                this.props.onSummonerFound({}, error);
            }
        );
    }

    /**
     * Makes a summoner search request
     * 
     * @param {String} summonerName The summoner to search
     * @param {*} success Successful calback
     * @param {*} error Erro callback
     */
    requestSummoner(summonerName, success, error) {
        return axios.get('/summoner/' + summonerName)
            .then(function(response) {
                return response.data;
            })
            .then(success)
            .catch(error);
    }

    render() {
        return (
            <div className="search-container">
                <form className="form"
                    onSubmit={this.onFormSubmit.bind(this)}>
                    <label htmlFor="s" 
                        className="form-label">
                        Search for a summoner
                    </label>
                    <input type="text" 
                        value={this.state.summonerName}
                        onChange={this.onInputChange.bind(this)}
                        name="s" />
                    
                    <button className="btn btn-primary btn-submit"
                        type="submit">
                        Search
                    </button>
                </form>
            </div>
        );
    }
}