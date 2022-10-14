import styled from 'styled-components'
import error from '../assets/img/404.svg'

const ErrorWrapper = styled.div`
  margin: 30px;
  display: flex;
  flex-direction: column;
  background-color: blue;
  align-items: center;
`

const ErrorTitle = styled.h1`
  font-weight: 300;
`

const ErrorSubtitle = styled.h2`
  font-weight: 300;
  color: blue;
`

const Illustration = styled.img`
  max-width: 800px;
`

function Error() {
    return (
        <ErrorWrapper>
            <ErrorTitle>Oups...</ErrorTitle>
            <Illustration src={error}/>
            <ErrorSubtitle>
                Il semblerait que la page que vous cherchez n’existe pas
            </ErrorSubtitle>
        </ErrorWrapper>
    )
}

export default Error