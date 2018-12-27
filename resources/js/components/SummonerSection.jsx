import React from 'react';
import axios from 'axios';
import isEmpty from 'lodash/isEmpty';
import SummonerProfile from './SummonerProfile';
import SummonerMatches from './SummonerMatches';

export default class SummonerSection extends React.Component {

    constructor(props) {
        super(props);
        this.renderSummonerProfile = this.renderSummonerProfile.bind(this);
        this.state = {
            summoner: {},
        }
    }

    componentDidUpdate(prevProps) {
        if (prevProps.summoner !== this.props.summoner) {
            this.setState({
                summoner: this.props.summoner,
            });
        }
    }

    render() {
        return (
            <div className="section-summoner">
                <div className="loading-spinner"></div>
                <div className="section-content">
                    {this.renderSummonerProfile()}
                    {this.renderSummonerMatches()}
                </div>
            </div>
        );
    }

    renderSummonerProfile() {
        if (!isEmpty(this.state.summoner)) {
            return (<SummonerProfile summoner={this.state.summoner} />);
        }
        return '';
    }

    renderSummonerMatches() {
        if (!isEmpty(this.state.summoner)) {
            return (<SummonerMatches summonerMatches={this.state.summoner.matches} />);
        }
        return '';
    }
}