import React, {Component, Fragment} from 'react';
import Loadable from 'react-loadable';
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom';

import Header from '../Header/Header';
import Home from '../Home/Home';
import Newsletter from '../Newsletter/Newsletter';
import Tags from '../Tags/Tags';
import Advertise from '../Advertise/Advertise';

import './App.css';

const NotFound = Loadable({
    loader: () => import('../NotFound/NotFound'),
    loading: () => <div>Loading...</div>
});

const Category = Loadable({
    loader: () => import('../Category/Category'),
    loading: () => <div>Loading...</div>
});

const Article = Loadable({
    loader: () => import('../Article/Article'),
    loading: () => <div>Loading...</div>
});

class App extends Component {
    constructor() {
        super();

        this.state = {
            loadAdvertise: false
        };
    }

    componentWillMount() {
        // this.onWindowClose();
    }

    componentDidMount() {
        setTimeout(() => {
            this.setState({
                loadAdvertise: true
            });
        }, 1000);
    }

    onWindowClose() {
        window.onbeforeunload = () => {
            return "Вы точно хотети утйи?";
        }
    }

    render() {
        return (
            <Router>
                <Fragment>
                    <Header/>
                    <Switch>
                        <Route exact path='/' component={Home}/>
                        <Route path='/category/:id' component={Category}/>
                        <Route path='/article/:id' component={Article}/>
                        <Route path='/tag/:id' component={Tags}/>
                        <Route path='**' component={NotFound}/>
                    </Switch>
                    <Newsletter/>
                    <div className="left__advertise">
                        {
                            this.state.loadAdvertise ? (
                                <Fragment>
                                    <Advertise />
                                    <Advertise />
                                </Fragment>
                            ) : (<p></p>)
                        }
                    </div>
                    <div className="right__advertise">
                        {
                            this.state.loadAdvertise ? (
                                <Fragment>
                                    <Advertise />
                                    <Advertise />
                                </Fragment>
                            ) : (<p></p>)
                        }
                    </div>
                </Fragment>
            </Router>
        );
    }
}

export default App;
