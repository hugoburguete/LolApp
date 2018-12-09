import React from 'react';
import axios from 'axios';
import SummonerLeague from './SummonerLeague';

export default class SummonerSection extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            summoner: props.summoner,
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
        let summoner = this.state.summoner;
        return (
            <div className="summoner-profile">
                <img src={"http://ddragon.leagueoflegends.com/cdn/6.24.1/img/profileicon/" + summoner.profile_icon_id + ".png"} alt=""/>
                <p>{summoner.name}</p>
                <p>Level {summoner.level}</p>
                {summoner.leagues ? summoner.leagues.map((league, key) => <SummonerLeague key={key} league={league} />) : ''}
            </div>
        );
    }
}