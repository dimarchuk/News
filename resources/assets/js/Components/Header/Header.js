import React, {Component, Fragment} from 'react';
import {Link, Redirect} from 'react-router-dom';
import Axios from 'axios';

import './Header.css';

import Search from '../Search/Search';
import DropDown from '../DropDown/DropDown';

export default class Header extends Component {
    constructor(props) {
        super();

        this.props = props;

        this.state = {
            isLogin: 0
        };
    }

    componentWillMount() {
        let isLogin;
        let userName;

        if (localStorage.getItem('isLogin') !== null && localStorage.getItem('userName') !== null) {
            isLogin = localStorage.getItem('isLogin');
            userName = localStorage.getItem('userName');
        }

        this.setState({
            isLogin: isLogin,
            userName: userName
        });
    }

    logout() {
        localStorage.setItem('isLogin', 0);
        localStorage.setItem('userName', '');
        location.reload();
        // Axios.post('api/logout')
        //     .then(response => {
        //         this.setState({
        //             isLogin: 0
        //         });
        //         localStorage.setItem('isLogin', 0);
        //         window.location.path = '/';
        //         // this.props.history.push('/');
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     });
    }

    render() {
        const isLogin = this.state.isLogin;
        const color = this.props.color;

        return (
            <header className='header' style={{backgroundColor: color}}>
                <Link to='/'>Home</Link>
                <Link to='/articles'>Articles</Link>
                <Search/>
                <DropDown />
                <div className="header__login">
                    {
                        isLogin == 1 ? (
                            <div>
                                <span onClick={this.logout.bind(this)}>Logout</span>
                                <Redirect to="/"/>
                            </div>
                        ) : (
                            <Fragment>
                                <Link to='/login'>Login</Link>
                                <Link to='/register'>Register</Link>
                                <Redirect to="/"/>
                            </Fragment>
                        )
                    }
                </div>
            </header>
        )
    }
}