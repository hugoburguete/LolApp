import React from 'react';
import { List, ListItem } from '../Widgets/List';
import Dummy from '../Widgets/Dummy';
import MatchListItem from './MatchListItem';

export default class SummonerMatches extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            summonerMatches: props.summonerMatches,
        }
    }

    componentDidUpdate(prevProps) {
        if (prevProps.summonerMatches !== this.props.summonerMatches) {
            this.setState({
                summonerMatches: this.props.summonerMatches,
            });
        }
    }

    onListItemSelected(item, data) {
        console.log('hello', data);
    }

    renderListItem(index, data) {
        return (<MatchListItem match={data} />);
    }

    render() {
        let summonerMatches = this.state.summonerMatches;
        return (
            <div>
                <h2>Matches</h2>
                <List 
                    items={summonerMatches}
                    itemRenderer={this.renderListItem}
                    onListItemSelected={this.onListItemSelected} >
                </List>
            </div>
        );
    }
}