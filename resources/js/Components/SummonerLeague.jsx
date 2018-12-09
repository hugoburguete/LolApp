import React from 'react';

export default class SummonerLeague extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            league: props.league,
        }
    }

    componentDidUpdate(prevProps) {
        if (prevProps.league !== this.props.league) {
            this.setState({
                league: this.props.league,
            });
        }
    }

    render() {
        let league = this.state.league;
        return (
            <div className="summoner-league">
                <h2>{league.queue_type}</h2>
                <p>{league.league_name}</p>
                <p>{league.rank} ({league.league_points} LP)</p>
                <p>Wins: {league.wins} | Losses: {league.losses}</p>
            </div>
        );
    }
}