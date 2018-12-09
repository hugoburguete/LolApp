import React from 'react';
import axios from 'axios';

export default class SummonerSection extends React.Component {

    constructor(props) {
        super(props);
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
                <div className="section-body">
                    
                </div>
            </div>
        );
    }
}