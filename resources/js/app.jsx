import React from 'react';
import ReactDOM from 'react-dom';
import { SearchForm } from './components';
import VerticalHorizontalCenteredContainer from './widgets/VerticalHorizontalCenteredContainer';

/**
 * The main application component
 */
class App extends React.Component {
    
    handleOnSummonerFound(summoner) {
        console.log(summoner);
    }

    render() {
        return (
            <div className="lolapp">
            	<div className="row">
	            	<div className="col-6">
                        <SearchForm 
                            onSummonerFound={this.handleOnSummonerFound.bind(this)} />
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
  