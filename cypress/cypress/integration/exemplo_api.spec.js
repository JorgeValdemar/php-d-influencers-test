/// <reference types="cypress" />

context('Validar teste de Requests', () => {
  const steps = {}

  steps.healthCheck = () => {
    it('A API está funcionando?', () => {

      cy.request(Cypress.config('baseUrl') + '/healthcheck')
        .should((response) => {
          expect(response.status).to.eq(200)
          // the server sometimes gets an extra comment posted from another machine
          // which gets returned as 1 extra object
          // expect(response.body).to.have.property('length').and.be.oneOf([500, 501])
          expect(response).to.have.property('headers')
          expect(response).to.have.property('duration')

        })
    })
  }

  steps.healthCheck();

})
