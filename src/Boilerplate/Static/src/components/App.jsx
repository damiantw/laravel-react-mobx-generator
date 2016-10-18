import React, { Component } from 'react';
import { observer } from 'mobx-react';
import DevTools from 'mobx-react-devtools';

@observer
class App extends Component {
    render() {

        var devTools = process.env.NODE_ENV === 'production' ? null : <DevTools/>;

        return (
            <div>
                <h1>Hello World</h1>
                { devTools }
            </div>
        );
    }
};

export default App;