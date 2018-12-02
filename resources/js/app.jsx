import React from 'react';
import ReactDOM from 'react-dom';
import {
    SearchForm, 
    SummonerSection
} from './components';
import isEmpty from 'lodash/isEmpty';
import VerticalHorizontalCenteredContainer from './widgets/VerticalHorizontalCenteredContainer';

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
            summoner: {}
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
        if (this.state.loading.summoner || !isEmpty(this.summoner)) classes.push('page-summoner');
        return classes.join(' ');
    }

    render() {
        return (
            <div className={this.getWrapperClasses()}>
            	<div className="row">
	            	<div className="col-6">
                        <SearchForm 
                            onFormSubmit={this.handleOnFormSubmit.bind(this)}
                            onSummonerFound={this.handleOnSummonerFound.bind(this)} />
                        <SummonerSection 
                            summoner={this.state.summoner}>
                        </SummonerSection>
	            	</div>
            	</div>
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
  