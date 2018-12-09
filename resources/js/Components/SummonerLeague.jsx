import React from 'react';

export default class SummonerLeague extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="summoner-league">
                {this.props.league.queue_type}
            </div>
        );
    }
}