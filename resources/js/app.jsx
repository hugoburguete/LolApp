import React from 'react';
import ReactDOM from 'react-dom';
import { SearchForm } from './components';
import VerticalHorizontalCenteredContainer from './widgets/VerticalHorizontalCenteredContainer';

/**
 * The main application component
 */
class App extends React.Component {
    render() {
        return (
            <div className="lolapp">
            	<div className="row">
	            	<div className="col-6">
	            		<VerticalHorizontalCenteredContainer>
	                		<SearchForm />
	            		</VerticalHorizontalCenteredContainer>
	            	</div>
	            	<div className="col-6">
						<div>Hello</div>
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
  