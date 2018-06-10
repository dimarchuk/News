import React, {Fragment, Component} from 'react'
import ReactDOM from 'react-dom';
import {BrowserRouter as Router, Switch, Route} from 'react-router-dom';
import Axios from 'axios';

import Index from './components/index';
import Login from './components/login';
import Register from './components/register';
import Home from './components/home';
import Forgot from './components/forgot';
import Reset from './components/reset';


import MainPage from './Components/Home/Home';
import Header from './Components/Header/Header';
import Category from './Components/Category/Category';
import Article from './Components/Article/Article';
import NotFound from './Components/NotFound/NotFound';
import Newsletter from './Components/Newsletter/Newsletter';
import Tags from './Components/Tags/Tags';
import Advertise from './Components/Advertise/Advertise';
import ArticlesList from './Components/Articles/ArticlesList';
import User from './Components/User/User';

import {apiUrl} from "./Helpers/index";

import './Components/App/App.css';

class App extends Component {
    constructor() {
        super();

        this.state = {
            loadAdvertise: false
        };
    }

    componentWillMount() {
        this.getBGColors();
    }

    getBGColors() {
        Axios.get(`${apiUrl}bgcolors`)
            .then(response => {
                this.setState({
                    bgheader: response.data.bgc_header,
                    bgbody: response.data.bgc_body
                });
            })
            .catch(error => console.log(error))
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
            <div className='body' style={{backgroundColor: this.state.bgbody, minHeight: '100vh'}}>

                <Router>
                    <Fragment>
                        <Header color={this.state.bgheader || ''}/>
                        {/*<div className='body' style={{backgroundColor: this.state.bgbody}}>*/}
                        <Switch>
                            <Route path='/articles' component={ArticlesList}/>
                            <Route exact path='/' component={MainPage}/>
                            <Route path='/category/:id' component={Category}/>
                            <Route path='/article/:id' component={Article}/>
                            <Route path='/tag/:id' component={Tags}/>
                            <Route path='/userinfo/:id' component={User}/>

                            <Route path='/login' component={Login}/>
                            <Route path='/register' component={Register}/>
                            <Route path='/home' component={Home}/>
                            <Route path='/forgotpassword' component={Forgot}/>
                            <Route path='/password/reset/:token' component={Reset}/>
                            <Route path='**' component={NotFound}/>
                        </Switch>

                        <Newsletter/>
                        <div className="left__advertise">
                            {
                                this.state.loadAdvertise ? (
                                    <Fragment>
                                        <Advertise/>
                                        <Advertise/>
                                        <Advertise/>
                                        <Advertise/>
                                    </Fragment>
                                ) : (<p></p>)
                            }
                        </div>
                        <div className="right__advertise">
                            {
                                this.state.loadAdvertise ? (
                                    <Fragment>
                                        <Advertise/>
                                        <Advertise/>
                                        <Advertise/>
                                        <Advertise/>
                                    </Fragment>
                                ) : (<p></p>)
                            }
                        </div>
                    </Fragment>
                </Router>
            </div>
        );
    }
}


ReactDOM.render(
    <App/>,
    document.getElementById('app')
);