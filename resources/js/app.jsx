import React from 'react';
import ReactDOM from 'react-dom';
import {
    SearchForm, 
    SummonerSection,
    SummonerMatches,
} from './components';
import isEmpty from 'lodash/isEmpty';

/**
 * The main application component
 */
class App extends React.Component {
    
    constructor(props) {
        super(props);
        this.state = {
            status: {
                ok: true,
                message: '',
            },
            loading: {
                summoner: false,
            },
            summoner: {},
            test: false,
        };
    }

    handleOnSummonerFound(summoner, err) {
        this.setState({
            loading: {
                summoner: false,
            },
            summoner: summoner
        });

        // TODO: Display correct error
        if (err) {
            this.setState({
                status: {
                    ok: false,
                    message: 'Failed to communicate to Riot\'s API'
                },
                summoner: summoner
            });
        }
    }
    
    handleOnFormSubmit() {
        this.setState({
            loading: {
                summoner: true,
            },
        })
    }

    getWrapperClasses() {
        var classes = ['lolapp'];
        if (this.state.loading.summoner) classes.push('loading');
        if (this.state.loading.summoner || !isEmpty(this.state.summoner)) classes.push('page-summoner');
        return classes.join(' ');
    }

    render() {
        return (
            <div className={this.getWrapperClasses()}>
                <SearchForm 
                    onFormSubmit={this.handleOnFormSubmit.bind(this)}
                    onSummonerFound={this.handleOnSummonerFound.bind(this)} />
                <SummonerSection 
                    summoner={this.state.summoner} />
            </div>
        );
    }
}

/**
 * Render application
 */
ReactDOM.render(
    <App />,
    document.getElementById('root')
);
  